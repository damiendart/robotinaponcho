require "rubygems"
require "bundler/setup"
Bundler.require(:default)

Haml::Filters::Scss.options[:cache] = false
Haml::Filters::Scss.options[:style] = :compressed

CLOBBER.include(FileList["site/index.html", "site/assets/foc-*.html"])
task :default => ["site/index.html", "site/assets/foc-footer.html",
    "site/assets/foc-header.html"]

desc "Spit out the homepage."
file "site/index.html" => FileList["site/_index.*"] do |task|
  puts "# Spitting out \"" + task.name + "\"."
  template = File.read("site/_index.haml")
  output = Haml::Engine.new(template, {:format => :html5,
        :escape_attrs => false, :attr_wrapper => "\""}).render
  output = Redcarpet::Render::SmartyPants.render(output)
  output = output.gsub(/^[\s]*$\n/, "")
  File.open(task.name, "w") do |file|
    file.write(output)
  end
end

%w{footer header}.each do |template_part|
  desc "Spit out The Folder of Crap #{template_part}."
  file "site/assets/foc-#{template_part}.html" =>
      FileList["site/assets/_folder-of-crap.*"] do |task|
    puts "# Spitting out \"" + task.name + "\"."
    template = File.read("site/assets/_folder-of-crap.haml")
    outputs = Haml::Engine.new(template, {:format => :html4,
          :escape_attrs => false,
          :attr_wrapper => "\""}).render.split(/<!-- TABLE -->/)
    output = outputs[(template_part.eql? "header") ? 0 : 1]
    output = Redcarpet::Render::SmartyPants.render(output)
    output = output.gsub(/^[\s]*$\n/, "")
    File.open(task.name, "w") do |file|
      file.write(output)
    end
  end
end
