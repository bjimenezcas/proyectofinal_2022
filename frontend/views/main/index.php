<?php

use yii\helpers\Url;
?>
<nav id="NavPrincipal" class="navbar navbar-expand-lg ">
	<div class="container-fluid">
		<a class="navbar-brand">Boda</a>
		<button class="custom-toggler navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarTogglerDemo02">
			<ul class="navbar-nav ms-auto mb-2 mb-lg-0 " style="float:right;">

				<li class="nav-item">
					<a class="nav-link" href="/">Inicio</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#fh5co-event">Evento</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#fh5co-gallery">Galeria</a>
				</li>
				<li class="nav-item"><a class="nav-link" href="#fh5co-testimonial">Contacto</a>
				</li>
			</ul>
		</div>
	</div>
</nav>

<header id="fh5co-header" class="fh5co-cover" role="banner" style="background-image:url(<?= Url::to(['@web/images/fiesta_bn.jpg']) ?>);" data-stellar-background-ratio="0.5">
	<div class="overlay"></div>
	<div class="container">
		<div class="row">
			<div class=" text-center">
				<div class="display-t">
					<div class="display-tc animate-box" data-animate-effect="fadeIn">
						<h1>Catalina  &amp;	Marco </h1>
						<h2 class="noscasamos">nos casamos en</h2>
						<div class="simply-countdown simply-countdown-one"></div>

					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="fh5co-couple">
		<div class="">
			<div class="row">
				<div class=" text-center fh5co-heading ">
					<h2>Donde!</h2>
					<h3 class="ms-1 me-1">La ceremonia será el 10 de Septiembre de 2022 en el Monasterio de San Juan de los Reyes a las 11:30 horas</p>
				</div>
			</div>
			<div class="row text-center">
				<div class="couple-half">
					<div class="groom">
					</div>
					<div class="desc-groom">
						<h3>Catalina</h3>
					</div>
				</div>
				<div class="couple-half">
					<div class="bride">
					</div>
					<div class="desc-bride">
						<h3>Marco</h3>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="fh5co-event" class="fh5co-bg" style="background-image:url(<?= Url::to(['@web/images/welcome.jpg']) ?>);">
		<div class="overlay"></div>
		<div class="container">
			<div class="row">
				<div class="col-md-8 col-md-offset-2 text-center fh5co-heading animate-box">
					<h2>Nuestro evento</h2>
				</div>
			</div>
			<div class="row">
				<div class="display-t">
					<div class="display-tc">
						<div class="row">
							<div class="col-md-6 col-sm-6 text-center">
								<div class="event-wrap animate-box">
									<h3>Ceremonia</h3>
									<div class="event-col">
										<i class="icon-clock"></i>
										<span>A las <br> 11:30 PM</span>
									</div>
									<div class="event-col">
										<i class="icon-calendar"></i>
										<span>Sabado 10</span>
										<span>Septiembre, 2022</span>
									</div>
									<p>La ceremonia será en <a href="https://goo.gl/maps/gPsnuCajWyMoe1LDA" target="_blank"> Monasterio de San Juan de los Reyes, Toledo</a></p>
								</div>
							</div>
							<div class="col-md-6 col-sm-6 text-center">
								<div class="event-wrap animate-box">
									<h3>Banquete</h3>
									<div class="event-col">
										<i class="icon-clock"></i>
										<span> A partir de las<br> 13:00 PM</span>
									</div>
									<div class="event-col">
										<i class="icon-calendar"></i>
										<span>Sabado 10</span>
										<span>Septiembre, 2022</span>
									</div>
									<p>Lo celebraremos en <a href="https://goo.gl/maps/bfDnQH9tFyvs7HJz7" target="_blank"> Cigarral del Ángel , Toledo</a></p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="fh5co-gallery" class="fh5co-section-gray" style="position: relative;">
		<div class="row">
			<div class=" text-center fh5co-heading animate-box">
				<span>NUESTRAS MEMORIAS</span>
				<h2>Galería de fotos</h2>
				<p></p>
			</div>
		</div>
		<div class="row ps-2" id="animated-thumbnails-gallery">
			<img class="gallery-item" style="" src="<?= Url::to(['@web/images/recuerdos/fotogaleria1.jpg']) ?>" />
			<img class="gallery-item" style="" src="<?= Url::to(['@web/images/recuerdos/fotogaleria2.jpg']) ?>" />
			<img class="gallery-item" style="" src="<?= Url::to(['@web/images/recuerdos/fotogaleria3.jpg']) ?>" />
			<img class="gallery-item" style="" src="<?= Url::to(['@web/images/recuerdos/fotogaleria4.jpg']) ?>" />

		</div>

		<audio id="myAudio" controls style="display: none;">
			<source src="<?= Url::to(['@web/music/im_yours.mp3']) ?>" type="audio/mpeg">
		</audio>
	</div>
	<div id="fh5co-testimonial">
				<div class="row animate-box">
					<div class="text-center fh5co-heading">
						<h2>Contacto</h2>
					</div>
				</div>
				<div class="row">
					<div class="col-12 animate-box">
						<div class="wrap-testimony">
							<div class="item">
								<div class=" testimony-slide active text-center">
									<div class="row mb-4 " id="" >
										<div class="col-5 offset-1">
											<div class="col-12">
											Catalina
											</div>
											<div class="col-12">
												<a href="tel:+696565856">696565856</a> <i class="fab fa-whatsapp"></i>
											</div>
										</div>
										<div class="col-5">
											<div class="col-12">
											Marco
											</div>
											<div class="col-12">
												<a href="tel:+685221243">685221243</a></span> <i class="fab fa-whatsapp"></i>
											</div>
										</div>
									</div>
									<div class="row text-center pb-5" id="IbanInfo">
										<div class="ps-4 col-12">
											<p>
												<iban id="cuenta">ES15 1515 1515 1515 1515 1515</iban>
											</p>
										</div>
										
										<div class="ps-4 col-12">
											<p>
												<button class="btn" data-clipboard-target="#cuenta">
													<i class="fas fa-copy" id="IdIconCopy"></i>
												</button>
											</p>
											<p style="color: #f40795; display: none" id="gracias">
												¡¡Gracias por formar parte de este día tan especial!!
											</p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
		</div>
	</div>
</header>