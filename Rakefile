require "haml"
require "rake"
require "rake/clean"

Haml::Filters::Scss.options[:style] = :compressed
Haml::Filters::Scss.options[:cache] = false

CLOBBER.include("foc-footer.html", "foc-header.html", "index.html")
task :default => ["foc-footer.html", "foc-header.html", "index.html"]

desc "Spit out the homepage."
file "index.html" => ["haml/index.haml", "javascript/index.js", 
    "scss/index.scss"] do |task|
  puts "# Spitting out \"" + task.name + "\"."
  template = File.read("haml/index.haml")
  output = Haml::Engine.new(template, {:format => :html5,
        :escape_attrs => false, :attr_wrapper => "\""}).render
  output = output.gsub(/^[\s]*$\n/, "")
  File.open(task.name, "w") do |file|
    file.write(output)
  end
end

%w{footer header}.each do |template_part|
  desc "Spit out The Folder of Crap #{template_part}."
  file "foc-#{template_part}.html" => ["haml/folder-of-crap.haml", 
      "javascript/folder-of-crap.js", "scss/folder-of-crap.scss"] do |task| 
    puts "# Spitting out \"" + task.name + "\"."
    template = File.read("haml/folder-of-crap.haml")
    outputs = Haml::Engine.new(template, {:format => :html4,
          :escape_attrs => false, 
          :attr_wrapper => "\""}).render.split(/<!-- TABLE -->/)
    output = outputs[(template_part.eql? "header") ? 0 : 1]
    output = output.gsub(/^[\s]*$\n/, "")
    File.open(task.name, "w") do |file|
      file.write(output)
    end
  end
end
