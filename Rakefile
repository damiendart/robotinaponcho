require "rubygems"
require "bundler/setup"
require "yaml"
Bundler.require(:default)

Haml::Filters::Scss.options[:cache] = false
Haml::Filters::Scss.options[:style] = :compressed

CLOBBER.include(FileList["gitweb/gitwebindextext.html",
    "site/index.html", "site/crap/index.cgi"])
task :default => ["gitweb/gitwebindextext.html", "site/index.html",
    "site/crap/index.cgi"]

desc "Spit out the Gitweb project overview include."
file "gitweb/gitwebindextext.html" =>
    FileList["gitweb/_gitwebindextext.*"] do |task|
  puts "# Spitting out \"" + task.name + "\"."
  output = File.read("gitweb/_gitwebindextext.markdown")
  output = output.gsub(/^<!--.*-->\n/m, "").strip
  output = "<pre>" + output + "</pre>\n"
  File.open(task.name, "w") do |file|
    file.write(output)
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
  output = Redcarpet::Render::SmartyPants.render(output)
  output = output.gsub(/^[\s]*$\n/, "")
  File.open(task.name, "w") do |file|
    file.write(output)
  end
end

desc "Spit out The Folder of Crap CGI script."
file "site/crap/index.cgi" => FileList["site/crap/_index.*"] do |task|
  puts "# Spitting out \"" + task.name + "\"."
  script = File.read("site/crap/_index.cgi")
  script = script.gsub(/__DATA__.*$/m, "")
  template = File.read("site/crap/_index.haml")
  output = Haml::Engine.new(template, {:format => :html5,
        :escape_attrs => false, :attr_wrapper => "\""}).render
  output = Redcarpet::Render::SmartyPants.render(output)
  # HACK: The SmartyPants parser doesn't like it when "HTMl::Template"'s tags
  # are used for HTML element attribute values.
  output = output.gsub(/&ldquo;/, "\"")
  output = output.gsub(/^[\s]*$\n/, "")
  File.open(task.name, "w") do |file|
    file.write(script)
    file.write("__DATA__\n")
    file.write(output)
  end
end
