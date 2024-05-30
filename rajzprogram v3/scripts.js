const canvas = document.getElementById('myCanvas');
const ctx = canvas.getContext('2d');
const painting = document.getElementById('myCanvas');
let paint_style = getComputedStyle(painting);
canvas.width = parseInt(paint_style.getPropertyValue('width'));
canvas.height = parseInt(paint_style.getPropertyValue('height'));

let mouse = {x: 0, y: 0};
let paintBucketActive = false;
let textObjects = []; 

canvas.addEventListener('mousemove', function(e) {
  mouse.x = e.pageX - this.offsetLeft;
  mouse.y = e.pageY - this.offsetTop;
}, false);

ctx.lineWidth = 3;
ctx.lineJoin = 'round';
ctx.lineCap = 'round';
ctx.strokeStyle = 'black';

window.addEventListener('resize', function() {
    const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
    paint_style = getComputedStyle(painting);
    canvas.width = parseInt(paint_style.getPropertyValue('width'));
    canvas.height = parseInt(paint_style.getPropertyValue('height'));
    ctx.putImageData(imageData, 0, 0);
});

canvas.addEventListener('mousedown', function(e) {
    const rect = this.getBoundingClientRect();
    mouse.x = e.clientX - rect.left;
    mouse.y = e.clientY - rect.top;

    if (paintBucketActive) {
        fill(mouse.x, mouse.y, ctx.strokeStyle);
    } else {
        ctx.beginPath();
        ctx.moveTo(mouse.x, mouse.y);

        canvas.addEventListener('mousemove', onPaint, false);
    }
}, false);

canvas.addEventListener('mouseup', function() {
    canvas.removeEventListener('mousemove', onPaint, false);
}, false);

const onPaint = function() {
    ctx.lineTo(mouse.x, mouse.y);
    ctx.stroke();
};

let backgroundColor = '#FFFFFF';

function changeColor(newColor) {
  ctx.strokeStyle = newColor;
  backgroundColor = newColor;
  ctx.globalAlpha = 1;
  ctx.shadowBlur = 0;
  ctx.globalCompositeOperation = 'source-over';
}

function useTool(toolType) {
  const colorPicker = document.getElementById('colorPicker');
  const lineWidth = document.getElementById('lineWidth');
  switch(toolType) {
    case 'pencil':
      ctx.strokeStyle = colorPicker.value;
      ctx.lineWidth = 1;
      ctx.globalAlpha = 1;
      ctx.shadowBlur = 0;
      ctx.globalCompositeOperation = 'source-over';
      paintBucketActive = false;
      break;
    case 'brush':
      ctx.strokeStyle = colorPicker.value ? colorPicker.value : 'red';
      ctx.lineWidth = lineWidth.value;
      ctx.lineJoin = 'round';
      ctx.lineCap = 'round';
      ctx.globalAlpha = 1; 
      ctx.shadowBlur = 10;
      ctx.shadowColor = ctx.strokeStyle;
      ctx.globalCompositeOperation = 'source-over'; 
      paintBucketActive = false;
      break;
    case 'eraser':
      ctx.strokeStyle = '#ffffff'; 
      ctx.lineWidth = 1; 
      ctx.lineJoin = 'miter'; 
      ctx.lineCap = 'butt'; 
      ctx.shadowBlur = 0; 
      paintBucketActive = false;
      break;
    default:
      break;
  }
}

function usePaintBucket() {
  paintBucketActive = true;
}

function changeLineWidth(newWidth) {
  ctx.lineWidth = newWidth;
}

function fill(startX, startY, fillColor) {
  ctx.fillStyle = fillColor;
  ctx.fill();
}

function saveDrawing() {
  var oldShadowBlur = ctx.shadowBlur;
  var oldShadowColor = ctx.shadowColor;
  ctx.shadowBlur = 0;
  ctx.shadowColor = 'rgba(0, 0, 0, 0)'; 
  ctx.globalCompositeOperation = 'destination-over';
  ctx.fillStyle = "white";
  ctx.fillRect(0, 0, canvas.width, canvas.height);
  ctx.shadowBlur = oldShadowBlur;
  ctx.shadowColor = oldShadowColor;
  var dataUrl = canvas.toDataURL('image/png');

  // Create a new FormData object
  var formData = new FormData();
  formData.append('image', dataUrl);

  // Send the image to the server
  var xhr = new XMLHttpRequest();
  xhr.open('POST', 'upload.php', true);
  xhr.send(formData);
}

function loadImage(event) {
  const file = event.target.files[0];
  if (!file) {
    console.error('No file selected');
    return;
  }

  const reader = new FileReader();

  reader.onerror = function() {
    console.error('Error occurred while reading the file');
  };

  reader.onload = function(event) {
    const img = new Image();

    img.onerror = function() {
      console.error('Error occurred while loading the image');
    };

    img.onload = function() {
      ctx.clearRect(0, 0, canvas.width, canvas.height); 
      ctx.drawImage(img, 0, 0, canvas.width, canvas.height); 
    };

    img.src = event.target.result;
  }

  reader.readAsDataURL(file);
}
function openImage() {
  useTool('pencil');

  const fileInput = document.getElementById('fileInput');
  fileInput.addEventListener('change', loadImage, false);
  fileInput.click();
}

function openTextBox() {
    var textBox = document.getElementById('text-box');
    textBox.style.display = 'block';
}

function addText() {
  var textBoxContent = document.getElementById('textBoxContent').value;
  var fontSize = document.getElementById('fontSize').value;
  var textColor = document.getElementById('textColor').value;

  var textObject = {
    text: textBoxContent,
    x: 100, 
    y: 100, 
    fontSize: fontSize || 20,
    color: textColor || '#000000'
  };

  textObjects.push(textObject);

  drawText(textObject); 

  var textBox = document.getElementById('text-box');
  textBox.style.display = 'none'; 
}

function drawText(textObject) {
  ctx.font = textObject.fontSize + 'px Arial';
  ctx.fillStyle = textObject.color;
  ctx.fillText(textObject.text, textObject.x, textObject.y);
}

canvas.addEventListener('mousedown', function(e) {
  var mouseX = e.clientX - canvas.offsetLeft;
  var mouseY = e.clientY - canvas.offsetTop;
  for (var i = textObjects.length - 1; i >= 0; i--) {
    var textObject = textObjects[i];
    ctx.font = textObject.fontSize + 'px Arial';
    var textWidth = ctx.measureText(textObject.text).width;
    var textHeight = textObject.fontSize;

    if (
      mouseX >= textObject.x &&
      mouseX <= textObject.x + textWidth &&
      mouseY >= textObject.y - textHeight &&
      mouseY <= textObject.y
    ) {
      var isDragging = true;
      var offsetX = mouseX - textObject.x;
      var offsetY = mouseY - textObject.y;

      canvas.addEventListener('mousemove', function(e) {
        if (isDragging) {
          var mouseX = e.clientX - canvas.offsetLeft;
          var mouseY = e.clientY - canvas.offsetTop;

          textObject.x = mouseX - offsetX;
          textObject.y = mouseY - offsetY;

          redrawCanvas();
        }
      });

      canvas.addEventListener('mouseup', function() {
        isDragging = false;
      });
      
      break;
    }
  }
});

function redrawCanvas() {
  ctx.clearRect(0, 0, canvas.width, canvas.height);
  for (var i = 0; i < textObjects.length; i++) {
    drawText(textObjects[i]);
  }
} 