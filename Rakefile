require "haml"
require "rake"
require "rake/clean"

CLOBBER.include("index.html")
task :default => "index.html"

desc "Spit out the homepage."
file "index.html" => ["index.haml", "index.scss"] do |task|
  puts "# Spitting out \"" + task.name + "\"."
  Haml::Filters::Scss.options[:style] = :compact
  template = File.read("index.haml")
  output = Haml::Engine.new(template, {:format => :html5,
        :escape_attrs => false, :attr_wrapper => "\""}).render
  output = output.gsub(/^[\s]*$\n/, "")
  File.open(task.name, "w") do |file|
    file.write(output)
  end
end
