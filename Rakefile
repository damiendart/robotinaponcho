# encoding: utf-8

# Rakefile for Damien Dart's personal website.
#
# Copyright (C) 2013-2016 Damien Dart, <damiendart@pobox.com>.
# This file is distributed under the MIT licence. For more information,
# please refer to the accompanying "LICENCE" file.

require "bundler/setup"
require "open3"
require "rubygems"
Bundler.require(:default)


Haml::Filters::Scss.options[:cache] = false
Haml::Filters::Scss.options[:style] = :compressed
Haml::Options.defaults[:attr_wrapper] = "\""
Haml::Options.defaults[:escape_attrs] = false
Haml::Options.defaults[:format] = :html5
# Increase the degree of precision of values that Sass spits out to
# prevent some browsers from rendering elements a pixel narrower than
# intended. See <https://github.com/nex3/sass/issues/319> for more
# information.
Sass::Script::Number.precision = 8


def process_haml_file(input_filename, output_filename, locals = {})
  puts "# Spitting out \"#{output_filename}\"."
  stdin, stdout, stderr = Open3.popen3("html-minifier --remove-comments " +
      "--decode-entities --collapse-whitespace -o #{output_filename}")
  stdin.puts(Redcarpet::Render::SmartyPants.render(Haml::Engine.new(
      File.read(input_filename)).render(Object.new, locals)))
end


%w{403 404 410}.each do |error_code|
  CLOBBER << "public/#{error_code}.html"
  desc "Spit out the #{error_code} HTTP error document."
  file "public/#{error_code}.html" => FileList["error.*", "Rakefile"] do |task|
    process_haml_file("error.haml", task.name, :error_code => error_code)
  end
end

CLOBBER << "public/index.html"
desc "Spit out the homepage."
file "public/index.html" => FileList["index.*", "common.*", "Rakefile"] do |task|
  process_haml_file("index.haml", task.name)
end

CLOBBER << "public/art/index.html"
directory "public/art"
desc "Spit out the art page."
file "public/art/index.html" => FileList["art.*", "common.*",
    "Rakefile", "public/art"] do |task|
  process_haml_file("art.haml", task.name)
end

CLOBBER << "public/crap/index.html"
directory "public/crap"
desc "Spit out The Folder of Crap page."
file "public/crap/index.html" => FileList["error.*", "Rakefile", "public/crap"] do |task|
  process_haml_file("error.haml", task.name, :error_code => "¯\\_(ツ)_/¯")
end

task :default => CLOBBER
