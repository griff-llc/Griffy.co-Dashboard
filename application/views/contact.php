<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view('html/head/include'); ?>
</head>

<body>
	<main class="main h-100 w-100">
		<div class="container h-100">
			<div class="row h-100">
				<div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
					<div class="d-table-cell align-middle">

						<div class="text-center mt-4">
							<h1 class="h2">Contact us</h1>
							<p class="lead">
                                Do you have any questions? Please do not hesitate to contact us directly.
							</p>
						</div>

						<div class="card">
                            <div class="card-body">
                                <form>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="inoutName">First Name</label>
                                            <input type="text" class="form-control" id="inputName" placeholder="First Name">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="surename">Sure Name</label>
                                            <input type="text" class="form-control" id="surename" placeholder="Surename">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Email address</label>
                                        <input type="email" class="form-control" placeholder="Email">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Subject</label>
                                        <input type="text" class="form-control" placeholder="Subject">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Your Message</label>
                                        <textarea class="form-control" placeholder="Start typing ..." rows="4"></textarea>
                                    </div>
    
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </form>
                            </div>
                        </div>
					</div>
				</div>
			</div>
		</div>
    </main>
    
    <?php $this->load->view('html/footer/contect');?>

	<script src="js/app.js"></script>

</body>
    <?php $this->load->view('html/footer/include'); ?>
</html>