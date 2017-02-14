var engine = Matter.Engine.create();
var render = Matter.Render.create({ element: document.body, engine: engine,
    options: { background: "none", hasBounds: true, wireframes: false } });

for(var i = 0; i < 30; i++) {
  var x = Matter.Common.random(-50, 50);
  var y = -2000 - (i > 0 ? 2000 : 0) - (i * 400);
  Matter.World.add(engine.world, Matter.Body.create({ parts: [
      // These magic numbers make up a robot:
      Matter.Bodies.rectangle(x, y, 100, 80), // the chest,
      Matter.Bodies.rectangle(x, y - 70, 60, 60), // the head,
      // the left and right arms,
      Matter.Bodies.rectangle(x - 60, y + 10, 20, 100),
      Matter.Bodies.rectangle(x + 60, y + 10, 20, 100),
      // and the left and right legs.
      Matter.Bodies.rectangle(x - 25, y + 70, 20, 80, { angle: 0.087 }),
      Matter.Bodies.rectangle(x + 25, y + 70, 20, 80, { angle: -0.087 })]}));
}
Matter.World.add(engine.world, Matter.Bodies.rectangle(
    0, 6, 5000, 10, { isStatic: true, render: { visible: false } }));

Matter.Events.on(render, "beforeRender", function(event) {
  event.source.canvas.width = event.source.canvas.offsetWidth;
  event.source.canvas.height = event.source.canvas.offsetHeight;
  // Updating the canvas width and height is not enough, see
  // <http://brm.io/matter-js/docs/classes/Render.html#property_bounds>.
  event.source.options.width = event.source.canvas.width;
  event.source.options.height = event.source.canvas.height;
  event.source.bounds = { min: { x: -event.source.canvas.width / 2,
      y: -event.source.canvas.height }, max: { x:
      event.source.canvas.width / 2, y: 0 } };
});

Matter.Engine.run(engine);
Matter.Render.run(render);
