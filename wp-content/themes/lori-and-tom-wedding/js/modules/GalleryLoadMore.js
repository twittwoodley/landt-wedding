import $ from 'jquery';

class GalleryLoadMore {
	constructor() {
		this.events();
	}

	events() {
		$(".load-more").on("click", this.loadMore.bind(this));
		}

	//Methods
	loadMore() {
		var imageCount = $(".gallery-container").data("imgcount");
		//console.log(imageCount);
		$.getJSON(themeData.root_url + '/wp-json/gallery/v1/images', {current_user : themeData.current_user, image_count : imageCount}, (slicedImages) => {
				//console.log(slicedImages[0]['maxPosts']);
				//console.log(imageCount);
				var maxPosts = slicedImages[0]['maxPosts'];
				if (maxPosts > imageCount) {
					slicedImages.forEach(function(image){`
					${$(".gallery-container").append(`
						<div class="gallery-image-thumb" style="background-image: url(${image.urlMeduimSize})">
							<div class="gallery-thumb-overlay">
								<div class="overlay-info-top">
									<h4 class="photographer-name">Uploaded by ${image.author}</h4>
									<a title="Enlarge" class="image-enlarge-link" href="${image.urlFullSize}" data-lightbox="roadtrip"><img src="${themeData.theme_uri + '/images/enlarge.png'}"></a>
								</div>
								<div class="overlay-info-bottom">
									<div class="like-box" data-like="${image.likeID}" data-photoID="${image.imageID}" data-exists="${image.existStatus}">
										<i title="Like" class="far fa-heart heart-empty" aria-hidden="true"></i>
										<i title="Unlike" class="fas fa-heart heart-filled" aria-hidden="true"></i>
										<span class="like-count">${image.likeCount}</span>
									</div>
									<a class="image-download-link" title="Download" href="${image.urlFullSize}" download><i class="fa fa-download"></i></a>
								</div>
							</div>
						</div>
					`)}	
				`});
				} else {
					$(".load-more").html("That\'s all folks!");
				}
				
			imageCount = $(".gallery-container").data("imgcount", imageCount + 8);
		});
	}
}

export default GalleryLoadMore;