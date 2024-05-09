const audio = document.getElementById('bgAudio');
    const playButton = document.getElementById('playButton');

    function togglePlayPause() {
      if (audio.paused) {
        audio.play();
        playButton.textContent = 'Pause Audio'; // Change button text to "Pause"
        playButton.classList.add('playing'); // Change button to green when playing
      } else {
        audio.pause();
        playButton.textContent = 'Play Audio'; // Change button text to "Play"
        playButton.classList.remove('playing'); // Revert button color when paused
      }
    }

    audio.onended = function() {
      playButton.textContent = 'Play Audio';
      playButton.classList.remove('playing'); // Revert button color when audio ends
    };