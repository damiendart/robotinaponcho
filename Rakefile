# encoding: utf-8

# Rakefile for Damien Dart's personal website.
#
# Copyright (C) 2013-2018 Damien Dart, <damiendart@pobox.com>.
# This file is distributed under the MIT licence. For more information,
# please refer to the accompanying "LICENCE" file.

require "bundler/setup"
require "digest"
require "open3"
require "open-uri"
require "rubygems"
require "yaml"
Bundler.require(:default)


ENV['SASS_PATH'] = "./sass"
Haml::Options.defaults[:attr_wrapper] = "\""
Haml::Options.defaults[:escape_attrs] = false
Haml::Options.defaults[:format] = :html5


config = YAML.load_file("config.yml")
pages = []


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
  open("https://www.instagram.com/#{config["site_author_instagram"]}/?__a=1",
      "If-Modified-Since" => File.exists?(task.name) ?
      File.stat(task.name).mtime.rfc2822 : "") do |f|
    open(task.name, "w") do |io|
      puts "# Spitting out \"#{task.name}\"."
      io.write f.read
    end if f.status[0] == "200"
  end
end

FileList["pages/**/*.{haml,md}"].map do |file|
  # The render queue (there's definitely a better name for this) allows
  # pages to be rendered using multiple templates, where the output of
  # one template is fed into the next.
  render_queue = []
  variables = Hash.new.merge(config)
  loop do
    parsed = FrontMatterParser::Parser.parse_file(
        render_queue.empty? ? file : "layouts/#{render_queue.last["layout"]}.haml")
    variables.merge!(parsed.front_matter) # FIXME: Handle overwriting values?
    render_queue << {"content" => parsed.content,
        "filename" => render_queue.empty? ? file : "layouts/#{render_queue.last["layout"]}.haml",
        "layout" => parsed.front_matter["layout"]}
    break if not render_queue.last["layout"]
  end
  # TODO: Add repository name?
  variables["page_git_last_commit_hash"],
      variables["page_git_last_commit_timestamp"],
      variables["page_git_last_commit_datetime"] =
      # To retrieve Git-related information on a file in a Git
      # submodule, the working directory must be set to the folder
      # containing the submodule. This does not affect retrieving
      # Git-related information in the superproject.
      `cd #{File.dirname(file)} && git log -n 1 --pretty=format:"%H %at %aD" #{File.basename(file)}`.split(" ", 3)
  variables["output_filename"] = file.gsub("pages", "public").ext("html")
  variables["page_slug"] ||= variables["output_filename"].gsub(/(index)?\.html/, "").gsub(/public\//, "")
  variables["page_url"] = config["site_url"] + variables["page_slug"]
  if File.extname(file) == ".md" and not variables["page_title"]
    # TODO: Support Atx-style headers?
    variables["page_title"] = render_queue[0]["content"][/^(.*)\n=+$/,1]
    render_queue.first["content"].gsub!(/^(.*\n=+)$/,"")
  end
  pages << variables.merge(render_queue.first)
  CLOBBER << variables["output_filename"]
  directory File.dirname(variables["output_filename"])
  desc "Spit out \"#{variables["output_filename"]}\"."
  file variables["output_filename"] => FileList["Rakefile", file.ext("*"),
      render_queue.collect { |i| "layouts/#{i["layout"]}.*" },
      variables["layout_dependencies"], variables["page_dependencies"],
      File.dirname(variables["output_filename"])].flatten.compact.reject { 
      |i| i =~ /\.+?$/ } do |task|
    output = ""
    puts "# Spitting out \"#{task.name}\"."
    render_queue.each do |item|
      case File.extname(item["filename"])
      when ".haml"
        output = Haml::Engine.new(item["content"]).render(Object.new,
            variables.merge("pages" => pages, "page_content" => output))
      when ".md"
        output = Redcarpet::Markdown.new(Redcarpet::Render::HTML).render(item["content"])
      end
    end
    stdin, stdout, stderr = Open3.popen3("html-minifier --collapse-whitespace " +
        "--decode-entities --minify-js --minify-css --remove-comments " +
        (variables["no_minify_urls"] ? "" : "--minify-ur-ls #{variables["page_url"]} ") +
        # HACK: Decode semi-colons and equals signs in GitWeb-related
        # URLs with sed after the HTML minification encodes them.
        "-o #{task.name} && sed -i 's/%3B/;/g; s/%3D/=/g' #{task.name}")
    stdin.puts(Redcarpet::Render::SmartyPants.render(output))
    stdin.close
  end
end

CLOBBER << "public/assets/avatar.jpg"
directory "pages/assets"
desc "Spit out \"public/assets/avatar.jpg\"."
file "public/assets/avatar.jpg" do |task|
  open("https://www.gravatar.com/avatar/#{Digest::MD5.hexdigest(config["site_author_email"])}",
      "If-Modified-Since" => File.exists?(task.name) ?
      File.stat(task.name).mtime.rfc2822 : "") do |f|
    open(task.name, "wb") do |io|
      puts "# Spitting out \"#{task.name}\"."
      io.write f.read
    end if f.status[0] == "200"
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
