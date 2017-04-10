var vendor = document.createElement("script");
var vendor_ready = false;
var loading = document.createElement("div");
var finished_loading = false;

loading.className = "javascript-loading";
document.getElementById("container").appendChild(loading);

setTimeout(function() {
  if(!finished_loading) {
    loading.classList.toggle("javascript-loading--show");
  }
}, 750);

vendor.src = "assets/index-vendor.js";
vendor.onload = vendor.onreadystatechange = function() {
  if(vendor_ready || this.readyState && this.readyState != "complete" &&
      this.readyState != "loaded") {
    return;
  }
  vendor_ready = true;
  var engine = Matter.Engine.create();
  var render = Matter.Render.create({
      element: document.getElementById("container"), engine: engine,
      options: { background: "none", wireframes: false } });
  var robot_path = document.createElementNS('http://www.w3.org/2000/svg', "path");
  // Use <https://github.com/duopixel/Method-Draw> to create this magic path.
  robot_path.setAttributeNS(null, "d", "m183.20443,69.59672c0,0 -43.09391,9.39226 -43.09391,9.39226c0,0 0,112.15467 -0.33154,111.6187c0.33154,0.53597 34.58568,13.79563 34.58568,13.79563c0,0 -54.69612,8.28729 -54.69612,8.28729c0,0 -4.97237,8.28729 -5.30391,7.75132c0.33154,0.53597 -61.5469,3.85089 -61.87844,3.31492c0.33154,0.53597 -19.55796,-24.3259 -19.55796,-24.3259c0,0 -16.0221,3.8674 -16.0221,3.8674c0,0 12.70718,51.3812 12.37564,50.84524c0.33154,0.53597 16.35363,9.92823 16.0221,9.39226c0.33154,0.53597 11.93375,-5.54138 11.60221,-6.07735c0.33154,0.53597 61.65749,-1.67398 61.32595,-2.20994c0.33154,0.53597 -9.06072,81.75142 -9.06072,82.30391c0,0.55249 25.41436,16.57458 25.08282,16.03861c0.33154,0.53597 -17.34802,76.22656 -17.67955,75.69059c0.33154,0.53597 -23.97785,4.95586 -23.97785,4.95586c0,0 -14.91712,18.78453 -15.24866,18.24855c0.33154,0.53597 29.06081,13.24315 28.72928,12.70718c0.33154,0.53597 48.39783,-12.17121 48.06629,-12.70718c0.33154,0.53597 18.01109,-82.88942 17.67955,-83.4254c0.33154,0.53597 38.45308,12.69066 38.45308,12.69066c0,0 35.91159,-15.46961 35.58005,-16.00558c0.33154,0.53597 25.19341,96.66855 24.86187,96.13257c0.33154,0.53597 63.86744,2.19343 63.5359,1.65746c0.33154,0.53597 8.06635,-12.72369 7.51386,-13.27618c-0.55249,-0.55249 -16.57458,-14.91712 -16.90612,-15.4531c0.33154,0.53597 -17.34801,-2.22646 -17.67955,-2.76243c0.33154,0.53597 -22.32039,-81.23197 -22.65193,-81.76794c0.33154,0.53597 31.82325,-9.96126 31.49171,-10.49724c0.33154,0.53597 -11.82315,-83.9944 -12.15469,-84.53037c0.33154,0.53597 67.73484,2.19343 67.4033,1.65746c0.33154,0.53597 12.48624,6.06083 12.48624,6.06083c0,0 11.60221,-14.36464 11.27067,-14.90061c0.33154,0.53597 8.61883,-33.71817 8.28729,-34.25414c0.33154,0.53597 -17.9005,-11.61872 -18.23204,-12.15469c0.33154,0.53597 -14.58558,20.97795 -14.91712,20.44198c0.33154,0.53597 -60.99441,1.64094 -61.32595,1.10497c0.33154,0.53597 -3.53586,-7.75132 -3.8674,-8.28729c0.33154,0.53597 -62.65187,-13.27618 -62.98341,-13.81215c0.33154,0.53597 32.92822,-9.96127 32.59668,-10.49724c0.33154,0.53597 0.88403,-116.03859 0.55249,-116.57456c0.33154,0.53597 -35.02757,-5.54138 -35.02757,-5.54138c0,0 -56.90607,1.10497 -56.90607,1.10497z");

  for(var i = 0; i < 20; i++) {
    Matter.World.add(engine.world, Matter.Bodies.fromVertices(0,
        -2000 - (i > 0 ? 2000 : 0) - (i * 400), Matter.Svg.pathToVertices(
        robot_path), { robot: true }));
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
      if (bodies[i].render.visible && bodies[i].robot) {
        context.translate(bodies[i].position.x, bodies[i].position.y);
        context.rotate(bodies[i].angle);
        context.drawImage(render.textures["assets/robot.png"],
            render.textures["assets/robot.png"].width * -0.50,
            render.textures["assets/robot.png"].height * -0.55,
            render.textures["assets/robot.png"].width,
            render.textures["assets/robot.png"].height);
        context.rotate(-bodies[i].angle);
        context.translate(-bodies[i].position.x, -bodies[i].position.y);
      }
    }
  };

  render.textures["assets/robot.png"] = new Image();
  render.textures["assets/robot.png"].src = "assets/robot.png";
  render.textures["assets/robot.png"].onload = function() {
    finished_loading = true;
    document.getElementsByClassName("javascript-loading")[0].className =
        "javascript-loading";
    Matter.Engine.run(engine);
    Matter.Render.run(render);
  };
};

document.getElementsByTagName("head")[0].appendChild(vendor);

document.getElementById("information-trigger").onchange = function(event) {
  document.documentElement.classList.toggle("javascript-info-visible");
  document.body.classList.toggle("javascript-info-visible");
};
