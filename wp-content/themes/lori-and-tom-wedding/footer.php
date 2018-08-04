	</div> <!-- content wrapper closing div -->
	<footer>
	</footer>
</div><!-- site wrapper closing div -->
</body>
<script>

(function() {
nav = document.querySelector('.nav-container');
container = document.querySelector(".content-wrapper");

container.style.marginTop= 'calc(30px + '  + nav.offsetHeight + 'px)';

})();

</script>
<?php wp_footer(); ?>