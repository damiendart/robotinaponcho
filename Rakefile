# Rakefile for Damien Dart's personal website.
#
# Copyright (C) 2013-2018 Damien Dart, <damiendart@pobox.com>.
# This file is distributed under the MIT licence. For more information,
# please refer to the accompanying "LICENCE" file.

require "bundler/setup"
require "open3"
require "rubygems"
Bundler.require(:default)


# As of Sass 3.4.0, the current working directory will no longer be
# placed onto the Sass load path by default.
ENV['SASS_PATH'] = "."
Haml::Options.defaults[:attr_wrapper] = "\""
Haml::Options.defaults[:escape_attrs] = false
Haml::Options.defaults[:format] = :html5


module Haml::Filters::AutoPrefixScss
  include Haml::Filters::Base
  def render(text)
    stdin, stdout, stderr = Open3.popen3("postcss --use autoprefixer")
    stdin.puts(Sass::Engine.new(text, {:cache => false, :syntax => :scss}).render)
    stdin.close
    "<style>#{stdout.read}</style>"
  end
end


base_template = Haml::Engine.new(File.read("base.haml"))


FileList["pages/**/*.haml"].map do |file|
  variables = { :javascript => [], :no_social => false, :scss => [] }
  variables.merge!(FrontMatterParser::Parser.parse_file(file).front_matter)
  variables["output_filename"] = file.gsub("pages", "public").ext("html")
  variables["page_slug"] = variables["output_filename"].gsub(/(index)?\.html/, "").gsub(/public\//, "")
  CLOBBER << variables["output_filename"]
  directory File.dirname(variables["output_filename"])
  desc "Spit out \"#{variables["output_filename"]}\"."
  file variables["output_filename"] => FileList["base.*", "Rakefile", 
      file.ext("*"), variables["dependencies"], 
      File.dirname(variables["output_filename"])].flatten.compact.uniq do |task|
    stdin, stdout, stderr = Open3.popen3("html-minifier --remove-comments " +
        "--minify-js --minify-css --decode-entities --collapse-whitespace -o #{task.name}")
    puts "# Spitting out \"#{task.name}\"."
    stdin.puts(Redcarpet::Render::SmartyPants.render(base_template.render(
        Object.new, variables.merge("page_content" => Haml::Engine.new(File.read(file)).render))))
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


task :default => CLOBBER
