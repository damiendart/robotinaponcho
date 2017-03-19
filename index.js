var vendor = document.createElement("script");

vendor.src = "assets/index-vendor.js";
vendor.onload = function() {
  var engine = Matter.Engine.create();
  var render = Matter.Render.create({ element: document.body, engine: engine,
      options: { background: "none", wireframes: false } });
  var robot_path = document.createElementNS('http://www.w3.org/2000/svg', "path");
  // I used <https://github.com/duopixel/Method-Draw> to generate this.
  robot_path.setAttributeNS(null, "d", "m176.99962,98.83092c-0.66668,0.66668 0,140.00246 -0.32984,139.83994c0.32984,0.16252 40.99723,12.16273 42.33058,12.16273c1.33336,0 0,6.66678 -0.32984,6.50426c0.32984,0.16252 -73.00478,6.16263 -72.3381,6.8293c0.66668,0.66668 -5.33343,12.66689 -5.66327,12.50437c0.32984,0.16252 -77.00485,3.49591 -77.00485,3.49591c0,0 -12.00021,-24.6671 -12.00021,-24.6671c0,0 -19.33367,-10.66685 -19.33367,-10.66685c0,0 -11.33353,4.66675 -10.66685,4.66675c0.66668,0 0,61.33441 0,61.33441c0,0 13.33357,-5.33343 13.00373,-5.49595c0.32984,0.16252 4.32991,13.49609 4.00007,13.33357c0.32984,0.16252 13.66341,10.1627 13.33357,10.00018c0.32984,0.16252 19.66351,-7.17094 18.99684,-6.50426c-0.66668,0.66668 72.00127,-2.66671 73.33462,-2.00004c1.33336,0.66668 -7.33346,86.00151 -7.66331,85.83899c0.32984,0.16252 23.66359,12.82941 24.99694,14.16277c1.33336,1.33336 50.66756,18.00032 52.66759,19.33367c2.00004,1.33336 72.00127,10.66685 72.00127,10.66685c0,0 105.33519,-54.66763 105.33519,-54.00095c0,0.66668 -7.33346,-73.33462 -7.66331,-73.49715c0.32985,0.16252 -4.3369,-56.50514 -4.3369,-56.50514c0,0 -75.33466,-11.33353 -75.33466,-11.33353c0,0 2.00004,-4.66675 1.67019,-4.82927c0.32985,0.16252 38.99719,-9.83766 38.66735,-10.00018c0.32985,0.16252 -0.33683,-145.84005 -0.66668,-146.00257c0.32985,0.16252 -44.33761,-9.83766 -44.33761,-9.83766c0,0 -98.6684,5.33343 -98.99825,5.17091c0.32984,0.16252 -23.0039,8.82934 -23.67058,9.49601z");
  // TODO: Explain this.
  document.getElementById("container").appendChild(
    document.getElementsByTagName("canvas")[0]);

  for(var i = 0; i < 30; i++) {
    Matter.World.add(engine.world, Matter.Bodies.fromVertices(
        Matter.Common.random(-150, 150),
        -2000 - (i > 0 ? 2000 : 0) - (i * 400),
        Matter.Svg.pathToVertices(robot_path), { robot: true }));
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
  // Use the original drawing function for debugging purposes.
  // var old_bodies_function = Matter.Render.bodies;
  Matter.Render.bodies = function(render, bodies, context) {
    // Use the original drawing function for debugging purposes.
    // old_bodies_function(render, bodies, context);
    for (i = 0; i < bodies.length; i++) {
      if (!bodies[i].render.visible) {
        continue;
      }
      if (bodies[i].robot) {
        var texture = render.textures["assets/robot.png"];
        if (!texture) {
          texture = render.textures["assets/robot.png"] = new Image();
          texture.src = "assets/robot.png";
        }
        context.translate(bodies[i].position.x, bodies[i].position.y);
        context.rotate(bodies[i].angle);
        context.drawImage(texture, texture.width * -0.61,
            texture.height * -0.59, texture.width, texture.height);
        context.rotate(-bodies[i].angle);
        context.translate(-bodies[i].position.x, -bodies[i].position.y);
      }
    }
  };

  Matter.Engine.run(engine);
  Matter.Render.run(render);
};

document.getElementsByTagName("head")[0].appendChild(vendor);
