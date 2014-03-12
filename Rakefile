# Rakefile for Damien Dart's personal website.
#
# Copyright (C) 2013, 2014 Damien Dart, <damiendart@pobox.com>.
# This file is distributed under the MIT licence. For more information,
# please refer to the accompanying "LICENCE" file.

require "rubygems"
require "bundler/setup"
require "yaml"
Bundler.require(:default)

Haml::Filters::Scss.options[:cache] = false
Haml::Filters::Scss.options[:style] = :compressed

ERROR_CODES = %w{403 404 410}
OUTPUT_FILES = ERROR_CODES.map{ |code| "site/#{code}.html" } +
    ["site/index.html", "site/googlefb3645e0f9f23eaf.html", "site/robots.txt",
    "site/crap/index.cgi"]

CLOBBER.include(OUTPUT_FILES)
task :default => OUTPUT_FILES

def tidyHTML(html_document)
  html_document = html_document.gsub(/^\s*$\n/, "")
  # HACK: Remove stray newlines from minified CSS which Sass 3.3 (and
  # newer) leaves behind.
  html_document = html_document.gsub(/}\s*(html|\.)/, "}\\1")
  return html_document
end

ERROR_CODES.each do |error_code|
  desc "Spit out the #{error_code} HTTP error document."
  file "site/#{error_code}.html" => FileList["site/_error.*"] do |task|
    puts "# Spitting out \"" + task.name + "\"."
    template = File.read("site/_error.haml")
    output = Haml::Engine.new(template, {:format => :html5,
        :escape_attrs => false, :attr_wrapper => "\""}).render(Object.new,
        :error_code => error_code)
    output = tidyHTML(output)
    File.open(task.name, "w") do |file|
      file.write(output)
    end
  end
end

desc "Spit out the homepage."
file "site/index.html" => FileList["site/_index.*"] do |task|
  puts "# Spitting out \"" + task.name + "\"."
  template = File.read("site/_index.haml")
  project_list = YAML.load_file("site/_index.yaml")
  output = Haml::Engine.new(template, {:format => :html5,
      :escape_attrs => false, :attr_wrapper => "\""}).render(Object.new,
      :projects => project_list)
  output = output.gsub(/<!--.*-->\n/m, "")
  output = tidyHTML(output)
  output = Redcarpet::Render::SmartyPants.render(output)
  File.open(task.name, "w") do |file|
    file.write(output)
  end
end

desc "Spit out Google Webmaster Tools' Verification file."
file "site/googlefb3645e0f9f23eaf.html" do |task|
  puts "# Spitting out \"" + task.name + "\"."
  File.open(task.name, "w") do |file|
    file.write("google-site-verification: " + File.basename(task.name) + "\n")
  end
end

desc "Spit out \"robots.txt\"."
file "site/robots.txt" do |task|
  puts "# Spitting out \"" + task.name + "\"."
  File.open(task.name, "w") do |file|
    file.write("User-agent: *\n")
    (ERROR_CODES.map{ |code| "#{code}.html" } + ["assets/", "icons/",
        "git/"]).each do |path|
      file.write("Disallow: /#{path}\n")
    end
  end
end

desc "Spit out The Folder of Crap CGI script."
file "site/crap/index.cgi" => FileList["site/crap/_index.*"] do |task|
  puts "# Spitting out \"" + task.name + "\"."
  script = File.read("site/crap/_index.pl")
  script = script.gsub(/__DATA__.*$/m, "")
  template = File.read("site/crap/_index.haml")
  output = Haml::Engine.new(template, {:format => :html5,
      :escape_attrs => false, :attr_wrapper => "\""}).render
  output = tidyHTML(output)
  output = output.gsub(%r{^\s*//.*\n}, "")
  output = Redcarpet::Render::SmartyPants.render(output)
  # HACK: The SmartyPants parser doesn't like it when "HTMl::Template"'s tags
  # are used for HTML element attribute values.
  output = output.gsub(/&ldquo;/, "\"")
  File.open(task.name, "w") do |file|
    file.write(script)
    file.write("__DATA__\n")
    file.write(output)
  end
end
