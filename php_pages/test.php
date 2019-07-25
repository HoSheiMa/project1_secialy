<html>
<head></head>


<body>
<button id=i>click</button>
  <script src="../socket.io.js"></script>
  <script>

  var s = io('http://localhost:8080/');
  document.querySelector('#i').onclick = () => {
    s.emit('incress', {});
  }

  </script>
</body>
</html>