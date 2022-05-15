$(function(){
    const container = document.querySelector('.Giraffe_contai');
		const Giraffe_banner = document.getElementsByClassName('Giraffe_banner')[0];
		const Giraffe_blocks = document.getElementsByClassName('Giraffe_blocks');
		for(var i = 0 ; i < 400 ; i++){
			const blocks = document.createElement('div');
			blocks.classList.add('block');
			container.appendChild(blocks);
		}
		function animeBlock(){
			anime({
				targets:'.block',
				rotate: 45,
				translateX: function(){
					return anime.random(-700,700);
				},
				translateY: function(){
					return anime.random(-500,500);
				},
				scale: function(){
					return anime.random(1,3)
				},
				easing:'linear',
				duration:3000,
				delay: anime.stagger(10),
				complete: animeBlock
			});
		}
		animeBlock();
});