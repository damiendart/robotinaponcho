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


FileList["pages/**/*.{haml,md}"].map do |file|
  # The render queue (there's definitely a better name for this) allows
  # pages to be rendered using multiple templates, where the output of
  # one template is fed into the next.
  render_queue = []
  variables = Hash.new.merge(config)
  variables["javascript"] = []
  variables["scss"] = []
  # For more information about recursive lambdas using Object#tap, see
  # <https://ciaranm.wordpress.com/2008/11/30/recursive-lambdas-in-ruby-using-objecttap/>.
  lambda do |r, filename|
    parsed = FrontMatterParser::Parser.parse_file(filename)
    layout = variables.merge!(parsed.front_matter){ |key, old, new|
        ["dependencies", "javascript", "scss"].include?(key) ? 
        [old, new].flatten : new }.delete("layout")
    render_queue << {"content" => parsed.content, "filename" => filename}
    r.call(r, "layouts/#{layout}.haml") if layout
  end.tap { |r| r.call(r, file) }
  # TODO: Add repository name?
  variables["page_git_last_commit_hash"],
      variables["page_git_last_commit_timestamp"],
      variables["page_git_last_commit_datetime"] =
      # To retrieve Git-related information on a file in a Git
      # submodule, the working directory must be set to the folder
      # containing the submodule. This does not affect retrieving
      # Git-related information in the superproject.
      `cd #{File.dirname(file)} && git log -n 1 --date=short --pretty=format:"%H %at %ad" #{File.basename(file)}`.split(" ", 3)
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
  file variables["output_filename"] => FileList["Rakefile",
      render_queue.collect { |i| i["filename"].ext("*") }, 
      variables["dependencies"], variables["javascript"], variables["scss"],
      File.dirname(variables["output_filename"])].flatten.compact.uniq do |task|
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

{ "pages/art/index.json" =>
      "https://www.instagram.com/#{config["site_instagram"]}/?__a=1",
  "public/assets/avatar.jpg" =>
      "https://www.gravatar.com/avatar/#{Digest::MD5.hexdigest(config["site_email"])}",
}.each do |filename, url|
  CLOBBER << filename
  directory File.dirname(filename)
  desc "Spit out \"#{filename}\"."
  file filename do |task|
    open(url, "If-Modified-Since" => File.exists?(filename) ?
        File.stat(filename).mtime.rfc2822 : "") do |f|
      open(filename, filename.match?(/jpg$/) ? "wb" : "w") do |io|
        puts "# Spitting out \"#{filename}\"."
        io.write f.read
      end if f.status[0] == "200"
    end
  end
end


task :default => CLOBBER
