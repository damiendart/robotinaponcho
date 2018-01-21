# encoding: utf-8

# Rakefile for Damien Dart's personal website.
#
# Copyright (C) 2013-2017 Damien Dart, <damiendart@pobox.com>.
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
# Increase the degree of precision of values that Sass spits out to
# prevent some browsers from rendering elements a pixel narrower than
# intended. See <https://github.com/nex3/sass/issues/319> for more
# information.
Sass::Script::Number.precision = 8


module Haml::Filters::AutoPrefixScss
  include Haml::Filters::Base
  def render(text)
    stdin, stdout, stderr = Open3.popen3("postcss --use autoprefixer")
    stdin.puts(Sass::Engine.new(text, {:cache => false, :syntax => :scss}).render)
    stdin.close
    "<style>#{stdout.read}</style>"
  end
end


FileList["pages/*.haml"].map do |file|
  # TODO: Be more graceful when "front matter" is unavailable.
  parsed = FrontMatterParser::Parser.parse_file(file)
  CLOBBER << "public/#{parsed.front_matter["output_file"]}"
  directory "public/#{File.dirname(parsed.front_matter["output_file"])}"
  desc "Spit out \"#{parsed.front_matter["output_file"]}\"."
  file "public/#{parsed.front_matter["output_file"]}" => FileList["Rakefile",
      # TODO: Support multiple dependencies.
      parsed.front_matter["rake_dependencies"],
      "layouts/#{parsed.front_matter["layout"]}.*",
      "pages/#{File.basename(file, ".haml")}.*"].compact do |task|
    puts "# Spitting out \"#{task.name}\"."
    stdin, stdout, stderr = Open3.popen3("html-minifier --remove-comments " +
        "--minify-js --minify-css --decode-entities --collapse-whitespace -o #{task.name}")
    stdin.puts(Redcarpet::Render::SmartyPants.render(Haml::Engine.new(
        File.read("layouts/#{parsed.front_matter["layout"]}.haml")).render(
        Object.new, parsed.front_matter.merge("page_content" =>
        Haml::Engine.new(parsed.content).render()))))
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
