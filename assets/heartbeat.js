setInterval(function() {
  fetch('/api/heartbeat.php?page=' + encodeURIComponent(location.pathname + location.search), {credentials: 'same-origin'});
}, 30000);
