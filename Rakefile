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

output_files = ["site/403.html", "site/404.html", "site/index.html",
    "site/googlefb3645e0f9f23eaf.html", "site/robots.txt",
    "site/crap/index.cgi"]
CLOBBER.include(output_files)
task :default => output_files

%w{403 404}.each do |error_code|
  desc "Spit out the #{error_code} HTTP error document."
  file "site/#{error_code}.html" => FileList["site/_error.*"] do |task|
    puts "# Spitting out \"" + task.name + "\"."
    template = File.read("site/_error.haml")
    output = Haml::Engine.new(template, {:format => :html5,
        :escape_attrs => false, :attr_wrapper => "\""}).render(Object.new,
        :error_code => error_code)
    output = output.gsub(/^[\s]*$\n/, "")
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
  output = output.gsub(/^[\s]*$\n/, "")
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
    ["403.html", "404.html", "assets/", "icons/", "git/"].each do |path|
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
  output = output.gsub(/^[\s]*$\n/, "")
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
