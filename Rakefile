# encoding: utf-8

# Rakefile for Damien Dart's personal website.
#
# Copyright (C) 2013-2018 Damien Dart, <damiendart@pobox.com>.
# This file is distributed under the MIT licence. For more information,
# please refer to the accompanying "LICENCE" file.

require "bundler/setup"
require "open3"
require "open-uri"
require "rubygems"
Bundler.require(:default)


ENV['SASS_PATH'] = "./sass"
Haml::Options.defaults[:attr_wrapper] = "\""
Haml::Options.defaults[:escape_attrs] = false
Haml::Options.defaults[:format] = :html5


module Haml::Filters::AutoPrefixScss
  include Haml::Filters::Base
  def render(text)
    stdin, stdout, stderr = Open3.popen3("postcss --use autoprefixer")
    stdin.puts(Sass::Engine.new(text, {:syntax => :scss}).render)
    stdin.close
    "<style>#{stdout.read}</style>"
  end
end


CLOBBER << "pages/art/index.json"
directory "pages/art"
desc "Spit out \"pages/art/index.json\"."
file "pages/art/index.json" do |task|
  open("https://www.instagram.com/damiendart/?__a=1",
      "If-Modified-Since" => File.exists?(task.name) ? File.stat(task.name).mtime.rfc2822 : "") do |f|
    puts f.status[0]
    open(task.name, "w") do |io|
      puts "# Spitting out \"#{task.name}\"."
      io.write f.read
    end if f.status[0] == "200"
  end
end

FileList["pages/**/*.{haml,md}"].map do |file|
  output_filename = file.ext("html").gsub!("pages", "public")
  # The render queue (there's definitely a better name for this) allows
  # pages to be rendered using multiple templates, where the output of
  # one template is fed into the next.
  (render_queue ||= []) << FrontMatterParser::Parser.parse_file(file)
  render_queue.last.front_matter["page_filename"] = file
  # TODO: Add repository name?
  render_queue.last.front_matter["page_git_last_commit_hash"],
      render_queue.last.front_matter["page_git_last_commit_timestamp"],
      render_queue.last.front_matter["page_git_last_commit_datetime"] =
      # To retrieve Git-related information on a file in a Git
      # submodule, the working directory must be set to the folder
      # containing the submodule. This does not affect retrieving
      # Git-related information in the superproject.
      `cd #{File.dirname(file)} && git log -n 1 --pretty=format:"%H %at %aD" #{File.basename(file)}`.split(" ", 2)
  if not render_queue.last.front_matter.key?("page_slug")
    render_queue.last.front_matter["page_slug"] = output_filename.gsub(/(index)?\.html/, "")
  end
  if File.extname(file) == ".md" and not render_queue.last.front_matter.key?("page_title")
    # TODO: Support Atx-style headers?
    render_queue.last.front_matter["page_title"] =
        render_queue.last.content[/^(.*)\n=+$/,1]
    render_queue.last.content.gsub!(/^(.*\n=+)$/,"")
  end
  while render_queue.last.front_matter.key?("layout") do
    render_queue << FrontMatterParser::Parser.parse_file(
        "layouts/#{render_queue.last.front_matter["layout"]}.haml")
    render_queue.last.front_matter["page_filename"] =
        "layouts/#{render_queue[-2].front_matter["layout"]}.haml"
  end
  CLOBBER << output_filename
  directory File.dirname(output_filename)
  desc "Spit out \"#{output_filename}\"."
  file output_filename => FileList["Rakefile", file.ext("*"),
      render_queue.collect { |i| "layouts/#{i.front_matter["layout"]}.*" },
      render_queue.collect { |i| i.front_matter["page_dependencies"] },
      File.dirname(output_filename)].compact.reject { |i| i =~ /\.\.?$/ } do |task|
    output = { content: "", front_matter: Hash.new }
    puts "# Spitting out \"#{task.name}\"."
    render_queue.each do |item|
      output[:front_matter].merge!(item.front_matter)
      case File.extname(item.front_matter["page_filename"])
      when ".haml"
        output[:content] = Haml::Engine.new(item.content).render(Object.new,
            output[:front_matter].merge("page_content" => output[:content]))
      when ".md"
        output[:content] = Redcarpet::Markdown.new(Redcarpet::Render::HTML).render(item.content)
      end 
    end
    stdin, stdout, stderr = Open3.popen3("html-minifier --remove-comments " +
        "--minify-js --minify-css --decode-entities --collapse-whitespace -o #{task.name}")
    stdin.puts(Redcarpet::Render::SmartyPants.render(output[:content]))
    stdin.close
  end
end

CLOBBER << "public/assets/index-vendor.js"
directory "public/assets"
desc "Spit out the concatenated vendor JavaScript file for the homepage."
file "public/assets/index-vendor.js" => FileList["Rakefile",
    "public/assets/pathseg.js", "public/assets/decomp.min.js",
    "public/assets/matter.min.js"] do |task|
  urls = ["https://github.com/progers/pathseg",
      "https://github.com/schteppe/poly-decomp.js",
      "https://github.com/liabru/matter-js/"]
  puts "# Spitting out \"#{task.name}\"."
  `uglifyjs #{task.prerequisites.drop(1).join(" ")} -o #{task.name} \
      --preamble "/* <#{urls.join(">, <")}> */"`
end

CLOBBER << "public/assets/style.css"
directory "public/assets"
desc "Spit out the site-wide CSS file."
file "public/assets/style.css" => FileList["Rakefile", "sass/*.scss"] do |task|
  puts "# Spitting out \"#{task.name}\"."
  stdin, stdout, stderr = Open3.popen3("postcss --use autoprefixer -o #{task.name}")
  stdin.puts(Sass::Engine.new(File.read("sass/style.scss"), {:syntax => :scss}).render)
  stdin.close
end


task :default => CLOBBER
