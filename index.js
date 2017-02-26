var engine = Matter.Engine.create();
var render = Matter.Render.create({ element: document.body, engine: engine,
    options: { background: "none", wireframes: false } });

for(var i = 0; i < 30; i++) {
  var x = Matter.Common.random(-150, 150);
  var y = -2000 - (i > 0 ? 2000 : 0) - (i * 400);
  Matter.World.add(engine.world, Matter.Body.create({ parts: [
      // These magic numbers make up a robot:
      Matter.Bodies.rectangle(x, y, 240, 190), // the chest,
      Matter.Bodies.rectangle(x - 5, y - 180, 170, 170), // the head,
      // and the left arm.
      Matter.Bodies.rectangle(x - 60, y + 10, 20, 100)],
      // The texture image dimensions should be 400 x 471 pixels.
      render: { sprite: { texture: "assets/robot.png", xOffset: 0.17,
      yOffset: 0.05 }}}));
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
  Matter.Render.lookAt(event.source, { bounds: { min:
      { x: -event.source.canvas.width / 2, y: -event.source.canvas.height },
      max: { x: event.source.canvas.width / 2, y: 0 } } });
});

// TODO: Explain why this function needs monkeypatching.
var old_bodies_function = Matter.Render.bodies;
Matter.Render.bodies = function(render, bodies, context) {
  // Use the original drawing function for debugging purposes.
  // old_bodies_function(render, bodies, context);
  for (i = 0; i < bodies.length; i++) {
    if (!bodies[i].render.visible) {
      continue;
    }
    if (bodies[i].render.sprite.texture) {
      var texture = render.textures[bodies[i].render.sprite.texture];
      if (!texture) {
        texture = render.textures[bodies[i].render.sprite.texture] = new Image();
        texture.src = bodies[i].render.sprite.texture;
      }
      context.translate(bodies[i].position.x, bodies[i].position.y);
      context.rotate(bodies[i].angle);
      context.drawImage(texture,
          texture.width * -bodies[i].render.sprite.xOffset * bodies[i].render.sprite.xScale,
          texture.height * -bodies[i].render.sprite.yOffset * bodies[i].render.sprite.yScale,
          texture.width * bodies[i].render.sprite.xScale,
          texture.height * bodies[i].render.sprite.yScale);
      context.rotate(-bodies[i].angle);
      context.translate(-bodies[i].position.x, -bodies[i].position.y);
    }
  }
};

Matter.Engine.run(engine);
Matter.Render.run(render);
