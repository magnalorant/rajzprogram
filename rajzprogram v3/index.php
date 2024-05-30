<?php
session_start(); 

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: start.php');
    exit;
} ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Paint App</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<canvas id="myCanvas" width="900" height="900">
    Your browser does not support the HTML5 canvas tag.
</canvas>

<div class="button-container">
    <button onclick="document.getElementById('colorPicker').click()">
        <img src="Assets/palette.png" alt="Válassz színt">
    </button>
    <input type="color" id="colorPicker" onchange="changeColor(this.value)">
    
    <button onclick="useTool('pencil')">
        <img src="Assets/pencil.png" alt="Ceruza">
    </button>
    
    <button onclick="useTool('eraser')">
        <img src="Assets/rubber.png" alt="Radír">
    </button>
    
    <button onclick="usePaintBucket()">
        <img src="Assets/paintbucket.png" alt="Színkitöltő">
    </button>
    
    <button onclick="useTool('brush')">
        <img src="Assets/paintbrush.png" alt="Ecset">
    </button>
    
    <button onclick="saveDrawing()">
        <img src="Assets/save.png" alt="Mentés">
    </button>
    
    <button onclick="openImage()">
        <img src="Assets/upload.png" alt="Feltöltés">
    </button>
    
    <button onclick="openTextBox()">
        <img src="Assets/text.png" alt="Szöveg">
    </button>

    <label for="lineWidth">Vonalvastagság:</label>
    <input type="range" id="lineWidth" min="1" max="10" value="3" oninput="changeLineWidth(this.value)">
    
    <input type="file" id="fileInput" accept="image/*" style="display: none;" onchange="loadImage(event)">
</div>

<div id="text-box" style="display: none; position: absolute; border: 1px solid black; background-color: white; padding: 5px;">
    <textarea id="textBoxContent" rows="4" cols="20" placeholder="Írja ide a szöveget"></textarea><br>
    <input type="number" id="fontSize" placeholder="Betűméret"><br>
    <input type="color" id="textColor" value="#000000">
    <button onclick="addText()">Hozzáadás</button>
</div>

<script src="scripts.js"></script>
</body>
</html>