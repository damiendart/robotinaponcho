# Rakefile for Damien Dart's personal website.
#
# Copyright (C) 2013-2018 Damien Dart, <damiendart@pobox.com>.
# This file is distributed under the MIT licence. For more information,
# please refer to the accompanying "LICENCE" file.

require "bundler/setup"
require "open3"
require "rubygems"
Bundler.require(:default)


module Haml::Filters::AutoPrefixScss
  include Haml::Filters::Base
  def render(text)
    stdin, stdout, stderr = Open3.popen3(
        "npx sass --stdin | npx postcss --use autoprefixer")
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


base_template = Haml::Engine.new(File.read("base.haml"))
default_page_values = YAML.load_file("base.yaml")


FileList["pages/**/*.haml"].map do |file|
  parsed = FrontMatterParser::Parser.parse_file(file)
  page = default_page_values.merge(parsed.front_matter) do |key, old, new|
    old.is_a?(Array) ? [old, new].flatten : new
  end
  page["content"] = parsed.content
  page["filename"] = file.gsub("pages", "public").ext("html")
  page["slug"] = page["filename"].gsub(/(public\/|(index)?\.html)/, "")
  page["url"] = page["url_base"] + page["slug"]
  CLOBBER << page["filename"]
  directory File.dirname(page["filename"])
  desc "Spit out \"#{page["filename"]}\"."
  file page["filename"] => FileList[
      "base.*", "Rakefile", file.ext("*"), page["dependencies"],
      File.dirname(page["filename"])].flatten.compact.uniq do |task|
    stdin, stdout, stderr = Open3.popen3("npx html-minifier --collapse-whitespace " +
        "--decode-entities --minify-js --minify-css --remove-comments " +
        (page["no_minify_urls"] ? "" : "--minify-ur-ls #{page["url"]} ") +
        # HACK: Decode semi-colons and equals signs in GitWeb-related
        # URLs with sed after the HTML minification encodes them.
        "-o #{task.name} && sed -i 's/%3B/;/g; s/%3D/=/g' #{task.name}")
    puts "# Spitting out \"#{task.name}\"."
    stdin.puts(Redcarpet::Render::SmartyPants.render(
        base_template.render(Object.new, page)))
  end
end

CLOBBER << "public/assets/index-vendor.js"
directory "public/assets"
desc "Spit out the concatenated vendor JavaScript file for the homepage."
file "public/assets/index-vendor.js" => FileList["Rakefile",
    "public/assets/decomp.min.js", "public/assets/matter.min.js"] do |task|
  urls = ["https://github.com/schteppe/poly-decomp.js",
      "https://github.com/liabru/matter-js/"]
  puts "# Spitting out \"#{task.name}\"."
  `npx uglifyjs #{task.prerequisites.drop(1).join(" ")} -o #{task.name} \
      -b beautify=false,preamble="'/* <#{urls.join(">, <")}> */'"`
end


task :default => CLOBBER
