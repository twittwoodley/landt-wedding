	</div> <!-- Site container closing div -->
</body>
<script>

(function() {
nav = document.querySelector('.nav-container');
container = document.querySelector(".site-container");

container.style.backgroundPosition= '0 ' + nav.offsetHeight + 'px';

document.getElementById("uploadForm").reset();
})();

</script>
<?php wp_footer(); ?>