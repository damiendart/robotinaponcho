// YO THIS CODE IS TERRIBLE AND NEEDS WORK.

var canvas = document.createElement("canvas");
var context = canvas.getContext("2d");
var engine = Matter.Engine.create();

var path = document.createElementNS("http://www.w3.org/2000/svg", "path");
path.setAttribute("d", "m46.881 20.435 13.824 25.244 12.021 125.02 17.43 66.11 12.624 49.29 20.43-54.1 55.9-102.78 49.29-78.732-55.3-34.26-76.332-12.622z");

document.body.appendChild(canvas);
Matter.World.add(engine.world, Matter.Bodies.rectangle(canvas.offsetWidth / 2,
    canvas.offsetHeight + 5, canvas.offsetWidth, 10, { isStatic: true }));
for(i = 0; i < 50; i++) {
Matter.World.add(engine.world, Matter.Bodies.fromVertices(
    Math.random() * window.innerWidth, (Math.random() * -500) - 500, 
    Matter.Svg.pathToVertices(path), { angle: Math.floor(Math.random() * 360), render: { sprite: { texture: "http://localhost:8080/art/artwork-1.png",
    xScale: 0.25, yScale: 0.25 } } }));
}

(function render()
{
  canvas.width = canvas.offsetWidth;
  canvas.height = canvas.offsetHeight;
  window.requestAnimationFrame(render);
  context.clearRect(0, 0, canvas.width, canvas.height);
  for (i = 0; i < Matter.Composite.allBodies(engine.world).length; i++) {
    body = Matter.Composite.allBodies(engine.world)[i];
    if (!body.render.visible) {
      continue;
    }
    for (k = body.parts.length > 1 ? 1 : 0; k < body.parts.length; k++) {
      part = body.parts[k];
      if (!part.render.visible) {
        continue;
      }
      if (part.render.sprite && part.render.sprite.texture) {
        var sprite = part.render.sprite,
            texture = new Image();
        texture.src = sprite.texture;

        context.translate(part.position.x, part.position.y); 
        context.rotate(part.angle);

        context.drawImage(
            texture,
            texture.width * -sprite.xOffset * sprite.xScale, 
            texture.height * -sprite.yOffset * sprite.yScale, 
            texture.width * sprite.xScale, 
            texture.height * sprite.yScale
        );

        // revert translation, hopefully faster than save / restore
        context.rotate(-part.angle);
        context.translate(-part.position.x, -part.position.y); 
      } else {
        if (part.circleRadius) {
          context.beginPath();
          context.arc(part.position.x, part.position.y, part.circleRadius, 0, 2 * Math.PI);
        } else {
          context.beginPath();
          context.moveTo(part.vertices[0].x, part.vertices[0].y);
          for (var j = 1; j < part.vertices.length; j++) {
            if (!part.vertices[j - 1].isInternal || showInternalEdges) {
              context.lineTo(part.vertices[j].x, part.vertices[j].y);
            } else {
              context.moveTo(part.vertices[j].x, part.vertices[j].y);
            }
            if (part.vertices[j].isInternal && !showInternalEdges) {
              context.moveTo(
                  part.vertices[(j + 1) % part.vertices.length].x, 
                  part.vertices[(j + 1) % part.vertices.length].y);
            }
          }
          context.lineTo(part.vertices[0].x, part.vertices[0].y);
          context.closePath();
        }
        context.fillStyle = "#153269";
        context.fill();
      } 
    }
  }
})();
Matter.Engine.run(engine);
