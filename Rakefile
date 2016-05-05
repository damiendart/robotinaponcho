# Rakefile for Damien Dart's personal website.
#
# Copyright (C) 2013-2016 Damien Dart, <damiendart@pobox.com>.
# This file is distributed under the MIT licence. For more information,
# please refer to the accompanying "LICENCE" file.

require "bundler/setup"
require "json"
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

MARKDOWN = Redcarpet::Markdown.new(Redcarpet::Render::HTML,
    disable_indented_code_blocks: true, fenced_code_blocks: true)
OUTPUT_FILES = []

FileList["pages/*.markdown"].each do |markdown_file|
  content = Nokogiri::HTML::DocumentFragment.parse(
      MARKDOWN.render(File.read(markdown_file)))
  metadata = JSON.parse(content.at_xpath("comment()[1]").text)
  output_filepath = markdown_file.gsub(".markdown", markdown_file.match(
      /index|\d{3}/) ? ".html" : "/index.html").gsub("pages", "public")
  OUTPUT_FILES << output_filepath
  directory output_filepath.pathmap("%d")
  desc "Spit out \"#{output_filepath}\"."
  file output_filepath => FileList["base.*",
      markdown_file.gsub("markdown", "*"),
      output_filepath.pathmap("%d"), "Rakefile"] do |task|
    puts "# Spitting out \"#{task.name}\"."
    output = Redcarpet::Render::SmartyPants.render(Haml::Engine.new(
        File.read("base.haml")).render(Object.new,
        {:body => content.to_html}.merge(metadata)))
    File.open(task.name, "w") do |file|
      file.write(output)
    end
    # FIXME: Find a better way of using "html-minifier".
    minified = `html-minifier --remove-comments --decode-entities --collapse-whitespace #{task.name}`
    File.open(task.name, "w") do |file|
      file.write(minified)
    end
  end
end

CLOBBER.include(OUTPUT_FILES)
task :default => OUTPUT_FILES
