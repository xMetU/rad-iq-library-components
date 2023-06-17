<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_myFrontPage
 */

defined('_JEXEC') or die('Restricted Access');

use Joomla\CMS\Factory;

$document = Factory::getDocument();
$document->addScript("media/com_myfrontpage/js/myFrontPageView.js");
$document->addStyleSheet("media/com_myfrontpage/css/style.css");

?>

<!-- FRONT PAGE VIEW -->

<!-- Header -->
<div class="row">
	<div class="col text-center mt-5">
		<h1>Welcome to Med Rad IQ Library!</h1>
		<h4>Image Repository and Learning Resource</h4>
	</div>
</div>

<hr/>

<!-- Content -->
<div class="row justify-content-center">
	<div class="col-10 card">
		<div class="card-body">
			<p>
				Welcome to Med Rad IQ Library, a web-based application that aims to serve as a comprehensive resource for Medical
				Imaging Students. Our library houses an extensive collection of radiographic images and content, carefully curated
				to facilitate a deeper understanding of Medical Imaging Studies (RADY courses). By providing real-world cases and
				images, we offer contemporary and relevant insights into the field of medical imaging.
			</p>

			<br/>

			<p>
				At Med Rad IQ Library, we understand the importance of practical learning. That's why we have integrated self-assessment
				modules and quizzes into our platform, allowing students to evaluate their progress and enhance their knowledge.
				Whether you're a budding medical imaging professional or a student looking to embark on a career in this field, our
				platform is here to provide you with essentail resources.
			</p>

			<br/>

			<p>
				This platform is a result of the collaboration between the STEM and Allied Health & Human Performance Academic Units
				at the University of South Australia. We are dedicated to fostering continuous learning and encouraging exploration
				in the field of medical imaging. Join us on this educational journey and unlock the possibilities that Med Rad IQ Library
				has to offer.
			</p>
		</div>
		
	</div>
</div>










