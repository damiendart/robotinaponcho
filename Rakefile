# Rakefile for Damien Dart's personal website.
#
# Copyright (C) 2013-2018 Damien Dart, <damiendart@pobox.com>.
# This file is distributed under the MIT licence. For more information,
# please refer to the accompanying "LICENCE" file.
#
# TODO: Document the folder structure this Rakefile expects.


# The following kludges allow this Rakefile to be easily used in other
# projects by using Node packages and Ruby gems already installed
# alongside it. NPM will install packages locally by default, while
# Bundler can be made to do so with "bundle install --standalone".
ENV["PATH"] = "#{__dir__}/node_modules/.bin:" + ENV["PATH"]

begin
  require_relative "bundle/bundler/setup"
rescue LoadError
  require "bundler"
  Bundler.setup
end

require "open3"
require "yaml"
require "front_matter_parser"
require "haml"
require "html-proofer"
require "rake"
require "rake/clean"
require "redcarpet"


module Haml::Filters::AutoPrefixScss
  include Haml::Filters::Base
  def render(text)
    stdin, stdout, stderr = Open3.popen3(
        "npx sass --stdin -I #{__dir__} | npx postcss --use autoprefixer")
    stdin.puts(text)
    stdin.close
    "<style>#{stdout.read}</style>"
  end
end

module Haml::Filters::Haml
  include Haml::Filters::Base
  def render(text)
    Haml::Engine.new(text).render
  end
end


OUTPUT_DIRECTORY = ENV["ROBOT_OUTPUT"] || "./public"


if (File.exist?("base.haml"))
  base = FrontMatterParser::Parser.parse_file("base.haml")
  base_template = Haml::Engine.new(base.content)
  sitemap_entries = []

  FileList["pages/**/*.haml"].map do |file|
    parsed = FrontMatterParser::Parser.parse_file(file)
    page = base.front_matter.merge(parsed.front_matter) do |key, old, new|
      old.is_a?(Array) ? [old, new].flatten : new
    end
    page["content"] = parsed.content
    page["filename"] = file.gsub("pages/", "").ext("html")
    page["slug"] = page["filename"].gsub(/(index)?\.html/, "")
    page["url"] = page["url_base"] + page["slug"]
    CLOBBER << File.join(OUTPUT_DIRECTORY, page["filename"])
    sitemap_entries << { :filename => CLOBBER.last, :url => page["url"] }
    directory File.dirname(CLOBBER.last)
    desc "Spit out \"#{CLOBBER.last}\"."
    file CLOBBER.last => FileList["base.*", File.expand_path(__FILE__),
        file.ext("*"), [page["dependencies"]].flatten.map{|d| d.gsub(/%OUTPUT_DIRECTORY%/, OUTPUT_DIRECTORY)},
        File.dirname(CLOBBER.last)].flatten.compact.uniq do |task|
      stdin, stdout, stderr = Open3.popen3("npx html-minifier --collapse-whitespace " +
          "--decode-entities --minify-js --minify-css --remove-comments " +
          (page["no_minify_urls"] ? "" : "--minify-urls #{page["url"]} ") +
          # HACK: Decode semi-colons and equals signs in GitWeb-related
          # URLs with sed after the HTML minification encodes them.
          "-o #{task.name} && sed -i 's/%3B/;/g; s/%3D/=/g' #{task.name}")
      puts "# Spitting out \"#{task.name}\"."
      stdin.puts(Redcarpet::Render::SmartyPants.render(
          base_template.render(Object.new, page)))
    end
  end

  CLOBBER << File.join(OUTPUT_DIRECTORY, "sitemap.xml")
  directory File.dirname(CLOBBER.last)
  desc "Spit out \"#{CLOBBER.last}\"."
  file CLOBBER.last => FileList[sitemap_entries.map{|e| e[:filename]}] do |task|
    puts "# Spitting out \"#{task.name}\"."
    File.open(task.name, "w") do |file|
      file.write("<?xml version=\"1.0\" encoding=\"UTF-8\"?>")
      file.write("<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">")
      sitemap_entries.each do |entry|
        # TODO: Add last modified attribute?
        file.write("<url><loc>#{entry[:url]}</loc></url>")
      end
      file.write("</urlset>")
    end
  end
end

if (File.exist?("assets.yaml"))
  assets_to_process = YAML.load_file("assets.yaml")
  assets_to_process.each do |asset|
    CLOBBER << File.join(OUTPUT_DIRECTORY, asset["output"])
    directory File.dirname(CLOBBER.last)
    desc "Spit out \"#{CLOBBER.last}\"."
    file CLOBBER.last => FileList[File.expand_path(__FILE__), "assets.yaml",
        File.dirname(CLOBBER.last), asset["input"]] do |task|
      puts "# Spitting out \"#{task.name}\"."
      case asset["processor"]
        # TODO: Add image processing?
        # TODO: Process by file extension?
        when "sass"
          `npx sass -I #{__dir__} #{task.prerequisites.drop(3).join(" ")} | \
              npx postcss --use autoprefixer | \
              npx cleancss -o #{task.name}`
        when "uglifyjs"
          `npx uglifyjs #{task.prerequisites.drop(3).join(" ")} \
              -o #{task.name} -b beautify=false,preamble="'#{asset["preamble"]}'"`
        else
          `cat #{task.prerequisites.drop(3).join(" ")} > #{task.name}`
      end
    end
  end
end

task :check do
  HTMLProofer.check_directory(OUTPUT_DIRECTORY).run
end


task :default => CLOBBER
