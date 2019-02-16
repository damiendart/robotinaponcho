var canvas = document.createElement("canvas");
var loading_animation = document.createElement("div");

loading_animation.className = "javascript-loading";
document.getElementById("container").appendChild(loading_animation);
document.getElementById("container").appendChild(canvas);

setTimeout(function() {
  loading_animation.className += " javascript-loading--show";
}, 750);

window.onload = window.onreadystatechange = function() {
  if (!this.readyState || /loaded|complete/.test(this.readyState)) {
    var accumulated_time = 0;
    var current_time = performance.now(); // TODO: Older broswers?
    var engine = Matter.Engine.create();

    for (var i = 0; i < 20; i++) {
      Matter.World.add(engine.world,
          Matter.Bodies.fromVertices(0, (i ? -4000 : -2000) - (i * 400),
              [{ "x":183.20443, "y":69.59672 }, { "x": 168.54849243164062, "y":72.79096221923828 }, { "x": 153.89254760742188, "y":75.9852066040039 }, { "x": 140.11052, "y":78.98898 }, { "x": 140.11026000976562, "y":79.8834228515625 }, { "x": 140.10581970214844, "y":94.8834228515625 }, { "x": 140.09616088867188, "y":109.88341522216797 }, { "x": 140.08087158203125, "y":124.88340759277344 }, { "x": 140.05967712402344, "y":139.88339233398438 }, { "x": 140.0308074951172, "y":154.88336181640625 }, { "x": 139.9840087890625, "y":169.88330078125 }, { "x": 139.89903259277344, "y":184.8830108642578 }, { "x": 139.77898000000002, "y":190.60768000000002 }, { "x": 148.31784057617188, "y":194.19268798828125 }, { "x": 162.27191162109375, "y":199.69570922851562 }, { "x": 174.36466000000001, "y":204.40331 }, { "x": 172.36424255371094, "y":204.70640563964844 }, { "x": 157.53350830078125, "y":206.95347595214844 }, { "x": 142.70277404785156, "y":209.2005615234375 }, { "x": 127.8720474243164, "y":211.44764709472656 }, { "x": 119.66854000000001, "y":212.69060000000002 }, { "x": 116.09659576416016, "y":218.3616943359375 }, { "x": 114.36463, "y":220.44192 }, { "x": 102.19525909423828, "y":221.43350219726562 }, { "x": 87.22085571289062, "y":222.30860900878906 }, { "x": 72.24110412597656, "y":223.0875701904297 }, { "x": 57.255165100097656, "y":223.7328643798828 }, { "x": 52.48619000000001, "y":223.75684 }, { "x": 46.066253662109375, "y":215.82530212402344 }, { "x": 36.68364715576172, "y":204.1220245361328 }, { "x": 32.928230000000006, "y":199.43094000000002 }, { "x": 24.188350677490234, "y":201.54055786132812 }, { "x": 16.906130000000008, "y":203.29834000000002 }, { "x": 18.706127166748047, "y":210.5880126953125 }, { "x": 22.29196548461914, "y":225.15310668945312 }, { "x": 25.86031723022461, "y":239.72250366210938 }, { "x": 29.28177000000001, "y":254.14358000000001 }, { "x": 29.402515411376953, "y":254.25521850585938 }, { "x": 42.26542663574219, "y":261.96502685546875 }, { "x": 45.30387, "y":263.53584 }, { "x": 55.61717224121094, "y":258.50103759765625 }, { "x": 56.90608, "y":257.45849 }, { "x": 70.20348358154297, "y":257.3226013183594 }, { "x": 85.1959457397461, "y":256.8485107421875 }, { "x": 100.18507385253906, "y":256.2779846191406 }, { "x": 115.16736602783203, "y":255.5543670654297 }, { "x": 118.23203000000001, "y":255.24855 }, { "x": 117.08129119873047, "y":267.09503173828125 }, { "x": 115.44092559814453, "y":282.0050048828125 }, { "x": 113.76744079589844, "y":296.9114074707031 }, { "x": 112.07937622070312, "y":311.81610107421875 }, { "x": 110.38591003417969, "y":326.7201843261719 }, { "x": 109.17131, "y":337.55246 }, { "x": 112.4931640625, "y":339.9393310546875 }, { "x": 125.11155700683594, "y":348.04901123046875 }, { "x": 134.25413, "y":353.59107 }, { "x": 133.43739318847656, "y":357.7914123535156 }, { "x": 130.1527099609375, "y":372.42724609375 }, { "x": 126.7794418334961, "y":387.0429992675781 }, { "x": 123.3598403930664, "y":401.6480712890625 }, { "x": 119.88859558105469, "y":416.2408752441406 }, { "x": 116.57458, "y":429.28166 }, { "x": 115.15287780761719, "y":429.7752380371094 }, { "x": 100.45735931396484, "y":432.7752990722656 }, { "x": 92.59673, "y":434.23751999999996 }, { "x": 88.21923828125, "y":439.7056884765625 }, { "x": 78.65080261230469, "y":451.25592041015625 }, { "x": 77.34806999999999, "y":452.48607 }, { "x": 89.28787994384766, "y":458.0545959472656 }, { "x": 103.04093933105469, "y":464.041748046875 }, { "x": 106.07735, "y":465.19325 }, { "x": 117.49455261230469, "y":462.5774230957031 }, { "x": 132.01197814941406, "y":458.8033447265625 }, { "x": 146.48594665527344, "y":454.86651611328125 }, { "x": 154.14364, "y":452.48607 }, { "x": 155.7703094482422, "y":445.7291259765625 }, { "x": 158.97674560546875, "y":431.07586669921875 }, { "x": 162.1194610595703, "y":416.40887451171875 }, { "x": 165.22430419921875, "y":401.7336730957031 }, { "x": 168.28895568847656, "y":387.05010986328125 }, { "x": 171.263427734375, "y":372.34808349609375 }, { "x": 171.82319, "y":369.06066999999996 }, { "x": 182.83436584472656, "y":372.8836975097656 }, { "x": 197.09909057617188, "y":377.5223693847656 }, { "x": 210.27627, "y":381.75132999999994 }, { "x": 211.34205627441406, "y":381.2913513183594 }, { "x": 225.0970916748047, "y":375.30810546875 }, { "x": 238.80484008789062, "y":369.2176208496094 }, { "x": 245.85632, "y":365.74574999999993 }, { "x": 247.71128845214844, "y":372.6170654296875 }, { "x": 251.5056915283203, "y":387.1291809082031 }, { "x": 255.27932739257812, "y":401.6466979980469 }, { "x": 259.0401611328125, "y":416.1675720214844 }, { "x": 262.7889404296875, "y":430.6915588378906 }, { "x": 266.52264404296875, "y":445.2195129394531 }, { "x": 270.2175598144531, "y":459.75726318359375 }, { "x": 270.71819, "y":461.8783199999999 }, { "x": 283.5066223144531, "y":462.5344543457031 }, { "x": 298.4995422363281, "y":462.994140625 }, { "x": 313.4949035644531, "y":463.36785888671875 }, { "x": 328.4925231933594, "y":463.62725830078125 }, { "x": 334.25409, "y":463.53577999999993 }, { "x": 339.1860656738281, "y":455.8143310546875 }, { "x": 341.76795000000004, "y":450.2595999999999 }, { "x": 335.2269287109375, "y":444.3304443359375 }, { "x": 324.86183000000005, "y":434.8064999999999 }, { "x": 323.9766540527344, "y":434.84814453125 }, { "x": 309.1539611816406, "y":432.58306884765625 }, { "x": 307.18228000000005, "y":432.0440699999999 }, { "x": 303.8240051269531, "y":419.5496826171875 }, { "x": 299.84405517578125, "y":405.0872497558594 }, { "x": 295.84619140625, "y":390.62982177734375 }, { "x": 291.8335266113281, "y":376.1766052246094 }, { "x": 287.80010986328125, "y":361.72900390625 }, { "x": 284.53035000000006, "y":350.2761299999999 }, { "x": 287.5219421386719, "y":349.571533203125 }, { "x": 301.80755615234375, "y":345.0002746582031 }, { "x": 315.9050598144531, "y":339.89453125 }, { "x": 316.02206000000007, "y":339.77888999999993 }, { "x": 314.0592956542969, "y":325.092529296875 }, { "x": 311.9573669433594, "y":310.2405090332031 }, { "x": 309.8295593261719, "y":295.3922119140625 }, { "x": 307.6802062988281, "y":280.547119140625 }, { "x": 305.499267578125, "y":265.7064514160156 }, { "x": 303.86737000000005, "y":255.24851999999993 }, { "x": 308.2644348144531, "y":255.56204223632812 }, { "x": 323.2551574707031, "y":256.0860290527344 }, { "x": 338.2496643066406, "y":256.4896545410156 }, { "x": 353.24603271484375, "y":256.81890869140625 }, { "x": 368.24456787109375, "y":257.01080322265625 }, { "x": 371.27067000000005, "y":256.90597999999994 }, { "x": 381.9998779296875, "y":262.1626892089844 }, { "x": 383.75691000000006, "y":262.96680999999995 }, { "x": 391.84539794921875, "y":252.70358276367188 }, { "x": 395.02758000000006, "y":248.06619999999995 }, { "x": 397.5138244628906, "y":239.079345703125 }, { "x": 401.0486145019531, "y":224.501953125 }, { "x": 403.31487000000004, "y":213.81205999999995 }, { "x": 399.8745422363281, "y":211.711669921875 }, { "x": 387.4099426269531, "y":203.3678436279297 }, { "x": 385.08283000000006, "y":201.65736999999996 }, { "x": 378.3158264160156, "y":211.67160034179688 }, { "x": 370.16571000000005, "y":222.09934999999996 }, { "x": 368.46337890625, "y":222.27928161621094 }, { "x": 353.4718017578125, "y":222.7677764892578 }, { "x": 338.4749755859375, "y":223.0760955810547 }, { "x": 323.4765625, "y":223.291259765625 }, { "x": 308.83976000000007, "y":223.20431999999997 }, { "x": 308.7423400878906, "y":222.93109130859375 }, { "x": 304.9723600000001, "y":214.91702999999995 }, { "x": 298.9450378417969, "y":213.8119659423828 }, { "x": 284.27020263671875, "y":210.7062225341797 }, { "x": 269.6152038574219, "y":207.5077362060547 }, { "x": 254.97579956054688, "y":204.23837280273438 }, { "x": 241.9889500000001, "y":201.10487999999995 }, { "x": 243.58389282226562, "y":200.8075408935547 }, { "x": 257.9358215332031, "y":196.4507598876953 }, { "x": 272.15155029296875, "y":191.66676330566406 }, { "x": 274.5856300000001, "y":190.60763999999995 }, { "x": 274.8062438964844, "y":178.293701171875 }, { "x": 274.9316711425781, "y":163.2943115234375 }, { "x": 275.0275573730469, "y":148.2946014404297 }, { "x": 275.10760498046875, "y":133.29486083984375 }, { "x": 275.17108154296875, "y":118.29493713378906 }, { "x": 275.2184753417969, "y":103.29499053955078 }, { "x": 275.2402038574219, "y":88.29505920410156 }, { "x": 275.1381200000001, "y":74.03307999999994 }, { "x": 274.42193603515625, "y":74.02720642089844 }, { "x": 259.5944519042969, "y":71.76634216308594 }, { "x": 244.80003356933594, "y":69.29158782958984 }, { "x": 240.11055000000007, "y":68.49169999999994 }, { "x": 229.86962890625, "y":68.6905517578125 }, { "x": 214.87246704101562, "y":68.98175811767578 }, { "x": 199.8752899169922, "y":69.27296447753906 }, { "x": 184.87811279296875, "y":69.56417083740234 }, { "x": 183.20448000000007, "y":69.59666999999993 }]));
    }
    Matter.World.add(engine.world,
        Matter.Bodies.rectangle(0, 6, 5000, 10, { isStatic: true }));
    loading_animation.className += " javascript-loading--complete";
    document.getElementById("container").className =
        "container--javascript-show-background";
    (function render() {
      // TODO: Add support for Retina displays?
      var bodies;
      var dt;
      var context = canvas.getContext("2d");
      var new_time = performance.now(); // TODO: Older browsers?
      // Setting "tick_length" to 60 often causes the first robot to
      // topple over in an unconvincing manner, because reasons.
      var tick_length = 61;

      dt = new_time - current_time;
      current_time = new_time;
      // Clamp "dt" to prevent the spiral of death that may occur if
      // updating start taking too long. For more information, see
      // <http://gafferongames.com/game-physics/fix-your-timestep/>.
      accumulated_time += (dt > 100) ? 100 : dt;
      while (accumulated_time >= (1000 / tick_length)) {
        Matter.Engine.update(engine, 1000 / tick_length, 0);
        accumulated_time -= (1000 / tick_length);
      }
      bodies = Matter.Composite.allBodies(engine.world);
      canvas.width = canvas.offsetWidth;
      canvas.height = canvas.offsetHeight;
      // Show more robots on smaller screens.
      if (screen.width < 768) {
        canvas.width *= 1.5;
        canvas.height *= 1.5;
      }
      context.fillStyle = "transparent";
      context.fillRect(0, 0, canvas.width, canvas.height);
      for (i = 0; i < bodies.length; i++) {
        if (!bodies[i].isStatic) {
          context.translate(bodies[i].position.x + (canvas.width / 2),
              bodies[i].position.y + canvas.height);
          context.rotate(bodies[i].angle);
          context.drawImage(document.images[0],
              document.images[0].width * -0.25,
              document.images[0].height * -0.275,
              document.images[0].width / 2,
              document.images[0].height / 2);
          context.rotate(-bodies[i].angle);
          context.translate(-bodies[i].position.x - (canvas.width / 2),
              -bodies[i].position.y - canvas.height);
          /* // Start debugging bits.
          context.beginPath();
          context.moveTo(
              bodies[i].parts[1].vertices[0].x + (canvas.width / 2),
              bodies[i].parts[1].vertices[0].y + canvas.height);
          for (j = 1; j < bodies[i].parts.length; j++) {
            for(k = 0; k < bodies[i].parts[j].vertices.length; k++) {
              context.lineTo(
                  bodies[i].parts[j].vertices[k].x + (canvas.width / 2),
                  bodies[i].parts[j].vertices[k].y + canvas.height);
            }
          }
          context.lineTo(
              bodies[i].parts[1].vertices[0].x + (canvas.width / 2),
              bodies[i].parts[1].vertices[0].y + canvas.height);
          context.closePath();
          context.stroke();
          // End debugging bits. */
        }
      }
      // TODO: Handle IE9's lack of "requestAnimationFrame"?
      window.requestAnimationFrame(render);
    })();
  }
};
