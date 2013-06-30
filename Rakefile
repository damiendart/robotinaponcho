require "haml"
require "rake"
require "rake/clean"

Haml::Filters::Scss.options[:cache] = false
(Haml::Filters::Scss.options[:load_paths] ||= []) << 
    File.join(File.dirname(__FILE__), "bourbon")
Haml::Filters::Scss.options[:style] = :compressed

CLOBBER.include(FileList["site/index.html", "site/assets/foc-*.html"])
task :default => ["site/index.html", "site/assets/foc-footer.html",
    "site/assets/foc-header.html"]

desc "Spit out the homepage."
file "site/index.html" => ["site/_index.haml", "site/_index.js", 
    "site/_index.scss"] do |task|
  puts "# Spitting out \"" + task.name + "\"."
  template = File.read("site/_index.haml")
  output = Haml::Engine.new(template, {:format => :html5,
        :escape_attrs => false, :attr_wrapper => "\""}).render
  output = output.gsub(/^[\s]*$\n/, "")
  File.open(task.name, "w") do |file|
    file.write(output)
  end
end

%w{footer header}.each do |template_part|
  desc "Spit out The Folder of Crap #{template_part}."
  file "site/assets/foc-#{template_part}.html" => 
      ["site/assets/_folder-of-crap.haml", "site/assets/_folder-of-crap.js", 
      "site/assets/_folder-of-crap.scss"] do |task| 
    puts "# Spitting out \"" + task.name + "\"."
    template = File.read("site/assets/_folder-of-crap.haml")
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
