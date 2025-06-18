@extends('layouts.web');

@section('content')

    <style>
        /* Client Slider Styles */
        .client-line {
            overflow: hidden;
            width: 100%;
            margin-top: 20px;
            white-space: nowrap;
            transition: transform 0.5s ease-in-out;
        }

        .client-box {
            width: 20%;
            display: inline-block;
        }

        .client-box img {
            width: 100%;
            height: 10vh;
            object-fit: contain;
            aspect-ratio: 3/2;
            /* mix-blend-mode: color-burn; */
        }

        .countdown {
            display: flex;
            font-size: 2em;
            color: #10497E;
        }

        .countdown div {
            display: flex;
            text-align: center;
        }

        .countdown div:not(:first-child) {

            margin-left: 16px;
        }

        .prio-area {}

        .prio-area li {
            padding-left: 30px;
            position: relative;
            margin-bottom: 3px;
        }

        .prio-area li:before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 24px;
            height: 24px;
            background: url('assets/icons/prio-icon.svg') no-repeat center center;
            background-size: contain;
        }

        .description {
            display: none;
            position: absolute;
            left: 30px;
            top: 30px;
            background-color: #f9f9f9;
            border: 1px solid #ccc;
            padding: 10px;
            z-index: 10;
            width: 200px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        ul li:hover .description {
            display: block;
        }
    </style>

    <!-- Banner Section Start -->
    <section class="banner-style-4 banner-padding" style="background-color: #fff;">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-md-12 col-xl-6 col-lg-6">
                    <div class="banner-content">
                        <h5 style="text-transform: capitalize; color: #10497E; font-weight: 600;">THE AFRICAN CONFERENCE
                            ON APPLIED INFORMATICS (ACAI)
                        </h5>
                        <p class="mb-10" style="color: #A41E22; font-weight: 600;">Hosted by the Same Quality Foundation
                        </p>
                        <p class="mb-10" style="color: #10497E; font-weight: 300;"> Synergy in Emergency Medicine:
                            Integrating training, innovation, and policy
                            development for better patient care.</p>

                        <p class="mb-10" style="color: #10497E; font-weight: 300;"> February 13th - 14th, 2025 <br>
                            Gran Melia Hotel, Arusha, Tanzania</p>
                        <p class="mb-40" style="color: #10497E; font-weight: 300;"> Workshop: February 10th - 12th, 2025
                        </p>
                        <div class="countdown mb-40">
                            <div>
                                <span id="days">0</span>
                                <p style="color: #10497E; margin-left: 16px; font-size: 0.5em;">Days</p>
                            </div>
                            <div>
                                <span id="hours">0</span>
                                <p style="color: #10497E; margin-left: 16px; font-size: 0.5em;">Hours</p>
                            </div>
                            <div>
                                <span id="minutes">0</span>
                                <p style="color: #10497E; margin-left: 16px; font-size: 0.5em;">Minutes</p>
                            </div>
                            <div>
                                <span id="seconds">0</span>
                                <p style="color: #10497E; margin-left: 16px; font-size: 0.5em;">Seconds</p>
                            </div>
                        </div>
                        <div class="btn-container" style="align-items: center; display: flex;">
                            <a href="#" class="btn btn-main rounded" style="padding: 8px;">Register Now <i
                                    class="fa fa-long-arrow-right" style="padding: 5px;"></i></a>
                            <a href="#" class="btn btn-main2" style=" 
                            border:2px solid #10497E; 
                            border-radius: 50%; 
                            padding: 10px; margin-left: 10px; 
                            justify-content: center; 
                            display: flex; 
                            height: 50px; 
                            width: 50px;"><i class="fa fa-play" style="color: #10497E; font-size: 1.5em;"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-xl-6 col-lg-6">
                    <div class="mt-0 mt-lg-0 ps-0" style="background-color: #10497E;">
                        <img src="assets/images/imagee.jpeg" alt="" class="img-fluid">
                    </div>
                </div>
            </div> <!-- / .row -->
        </div> <!-- / .container -->
    </section>
    <!-- Banner Section End -->

    <!-- Counter Section start -->
    <section class="counter-section4">
        <div class="container">
            <div class="row justify-content-center" style="height: 400px;">
                <div class="video-section mt-3 mt-xl-0">
                    <div class="video-content">
                        <img src="assets/images/bg/office01.html" alt="" class="img-fluid">
                        <a href="#" class="video-icon video-popup"><i class="fa fa-play"></i></a>
                    </div>
                </div>
            </div>
        </div>
        
    </section>
    <!-- COunter Section End -->

    <!--  Guest of honor -->
    <section class="section-instructors section-padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8">
                    <div class="section-heading mb-10 text-center">
                        <h5>ACAI 2024</h5>
                        <h3>Guest of Honour</h3>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="team-item mb-7">
                        <div class="team-img" style="padding-top: 5%;">
                            <img src="assets/images/team/team-4.jpg" alt="" class="img-fluid">
                        </div>
                        <div class="team-content text-center">
                            <div class="team-info">
                                <h5>Prof. Eliamani Sedoyeka</h5>
                                <p>Chief Host <br>
                                    Institute of Accountancy Arusha, Tanzania</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--  end guest of honor -->

    <!--  Keytone speakers -->
    <section class="section-instructors">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8">
                    <div class="section-heading mb-70 text-center">
                        <h5>ACAI 2024</h5>
                        <h3>Keytone Speakers</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="team-item mb-5">
                        <div class="team-img">
                            <img src="assets/images/team/team-4.jpg" alt="" class="img-fluid">
                        </div>
                        <div class="team-content text-center" style="margin-left: 9px; width: 250px;">
                            <div class="team-info">
                                <h6>Prof. Eliamani Sedoyeka</h6>
                                <p>Chief Host <br>
                                    Institute of Accountancy Arusha, Tanzania</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="team-item mb-5">
                        <div class="team-img">
                            <img src="assets/images/team/team-4.jpg" alt="" class="img-fluid">
                        </div>
                        <div class="team-content text-center" style="margin-left: 9px; width: 250px;">
                            <div class="team-info">
                                <h6>Prof. Eliamani Sedoyeka</h6>
                                <p>Chief Host <br>
                                    Institute of Accountancy Arusha, Tanzania</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="team-item mb-5">
                        <div class="team-img">
                            <img src="assets/images/team/team-4.jpg" alt="" class="img-fluid">
                        </div>
                        <div class="team-content text-center" style="margin-left: 9px; width: 250px;">
                            <div class="team-info">
                                <h6>Prof. Eliamani Sedoyeka</h6>
                                <p>Chief Host <br>
                                    Institute of Accountancy Arusha, Tanzania</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="team-item mb-5">
                        <div class="team-img">
                            <img src="assets/images/team/team-4.jpg" alt="" class="img-fluid">
                        </div>
                        <div class="team-content text-center" style="margin-left: 9px; width: 250px;">
                            <div class="team-info">
                                <h6>Prof. Eliamani Sedoyeka</h6>
                                <p>Chief Host <br>
                                    Institute of Accountancy Arusha, Tanzania</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="team-item mb-5">
                        <div class="team-img">
                            <img src="assets/images/team/team-4.jpg" alt="" class="img-fluid">
                        </div>
                        <div class="team-content text-center" style="margin-left: 9px; width: 250px;">
                            <div class="team-info">
                                <h6>Prof. Eliamani Sedoyeka</h6>
                                <p>Chief Host <br>
                                    Institute of Accountancy Arusha, Tanzania</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="team-item mb-5">
                        <div class="team-img">
                            <img src="assets/images/team/team-4.jpg" alt="" class="img-fluid">
                        </div>
                        <div class="team-content text-center" style="margin-left: 9px; width: 250px;">
                            <div class="team-info">
                                <h6>Prof. Eliamani Sedoyeka</h6>
                                <p>Chief Host <br>
                                    Institute of Accountancy Arusha, Tanzania</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="team-item mb-5">
                        <div class="team-img">
                            <img src="assets/images/team/team-4.jpg" alt="" class="img-fluid">
                        </div>
                        <div class="team-content text-center" style="margin-left: 9px; width: 250px;">
                            <div class="team-info">
                                <h6>Prof. Eliamani Sedoyeka</h6>
                                <p>Chief Host <br>
                                    Institute of Accountancy Arusha, Tanzania</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="team-item mb-5">
                        <div class="team-img">
                            <img src="assets/images/team/team-4.jpg" alt="" class="img-fluid">
                        </div>
                        <div class="team-content text-center" style="margin-left: 9px; width: 250px;">
                            <div class="team-info">
                                <h6>Prof. Eliamani Sedoyeka</h6>
                                <p>Chief Host <br>
                                    Institute of Accountancy Arusha, Tanzania</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--  end Keytone speakers -->
    <!-- map section start -->
    <section class="features section-padding-btm section-padding">
        <div class="container">
            <div class="row justify-content-end mb-50">
                <div class="col-xl-6 col-lg-6 mt-7">
                    <div class="section-heading mt-5 mt-lg-0 mb-4">
                        <h3 style="margin-bottom: 20px;">Introduction</h3>
                        <p style="margin-top: 10px; line-height: 1.5; text-align: justify;">
                            The African Conference on Applied Informatics, is the annual events taking place in Arusha,
                            Tanzania, every year. This event
                            intends to provide a platform for researchers, scholars and experts to present their latest
                            research findings, methodologies,
                            theories and practical experience on different issues. In this regard, it provides a
                            platform for them to share their knowledge and
                            receive feedback from their peers. The conference theme for this year is “Harnessing Applied
                            Informatics for Social and Economic
                            Development”. It reflects the need for developing countries to engage in the application of
                            ICTs to address social and economic
                            setbacks faced by the society. All accepted papers will be published in the conference
                            proceedings after a peer review process.
                            All conference papers will have the ISSN. In addition, outstanding papers will be published
                            in the Journal of Informatics, with the
                            DOI and ISSN</p>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6" style="padding-left: 70px;">
                    <div class="section-heading mt-5 mt-lg-0 mb-4">
                        <h3 style="margin-bottom: 20px;">Priority Areas</h3>
                        <p style="margin-top: 10px; line-height: 1.5;">
                            The African Conference on Applied Informatics make a call for papers in the following
                            priority areas:</p>
                        <ul class="prio-area">
                            <li>Data Science and Machine Learning
                            </li>
                            <li>ICT4Dev</li>
                            <li>ICT Security</li>
                            <li>ICT Systems Management</li>
                            <li>Operating Systems and Networking</li>
                            <li>Programming and Databases</li>
                            <li>Digitalization and Digital Inclusion</li>
                            <li>Mobile Applications</li>
                            <li>Library Science</li>
                            <li>Records Management</li>
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end map section start -->
    <!--  Gallery -->
    <section class="section-instructors">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8">
                    <div class="section-heading mb-70 text-center">
                        <h6 class="font-lg">conference gallery</h6>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="team-item mb-5">
                        <div class="team-img">
                            <img src="assets/images/team/team-2.jpg" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="team-item mb-5">
                        <div class="team-img">
                            <img src="assets/images/team/team-2.jpg" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="team-item mb-5">
                        <div class="team-img">
                            <img src="assets/images/team/team-2.jpg" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="team-item mb-5">
                        <div class="team-img">
                            <img src="assets/images/team/team-2.jpg" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="team-item mb-5">
                        <div class="team-img">
                            <img src="assets/images/team/team-2.jpg" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="team-item mb-5">
                        <div class="team-img">
                            <img src="assets/images/team/team-2.jpg" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="team-item mb-5">
                        <div class="team-img">
                            <img src="assets/images/team/team-2.jpg" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--  Gallery -->

    <!--  our partner -->
    <section class="category-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8">
                    <div class="heading mb-50 text-center">
                        <h3 class="font-lg">Our Partners</h3>
                    </div>
                </div>
            </div>
            <div class="client-line" id="clientSlider">
                <div class="client-box">
                    <img src="assets/images/tpb.png" alt="Client Logo 1">
                </div>
                <div class="client-box">
                    <img src="assets/images/psptb.png" alt="Client Logo 1">
                </div>
                <div class="client-box">
                    <img src="assets/images/tff.png" alt="Client Logo 1">
                </div>
                <div class="client-box">
                    <img src="assets/images/tpb.png" alt="Client Logo 1">
                </div>
                <div class="client-box">
                    <img src="assets/images/psptb.png" alt="Client Logo 1">
                </div>
                <div class="client-box">
                    <img src="assets/images/tff.png" alt="Client Logo 1">
                </div>
                <div class="client-box">
                    <img src="assets/images/tpb.png" alt="Client Logo 1">
                </div>
                <div class="client-box">
                    <img src="assets/images/psptb.png" alt="Client Logo 1">
                </div>
                <div class="client-box">
                    <img src="assets/images/tff.png" alt="Client Logo 1">
                </div>
                <div class="client-box">
                    <img src="assets/images/tpb.png" alt="Client Logo 1">
                </div>
                <div class="client-box">
                    <img src="assets/images/psptb.png" alt="Client Logo 1">
                </div>
                <div class="client-box">
                    <img src="assets/images/tff.png" alt="Client Logo 1">
                </div>
            </div>
        </div>
    </section>
    <!-- end our partiner -->

    <!-- Tour Partners -->
    <section class="section-instructors section-padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8">
                    <div class="section-heading mb-10 text-center">
                        <h5>ACAI 2024</h5>
                        <h3>Official Conference Tour Partner</h3>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="team-item mb-7">
                        <div class="team-img" style="margin: 20px 80px 10px 80px;">
                            <img src="assets/images/team/team-4.jpg" alt="" class="img-fluid">
                        </div>
                        <div class=" text-center">
                            <div class="btn-container">
                                <a href="tour.html" class="btn btn-main rounded">SEE ALL TOURISM DETAILS <i
                                        class="fa fa-angle-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--  end Tour Partners -->

    <!-- map section start -->
    <section class="features section-padding-btm">
        <div class="container">
            <div class="row align-items-center justify-content-end mb-50">
                <div class="col-xl-6 col-lg-6 ">
                    <div class="section-heading mt-5 mt-lg-0 mb-4">
                        <h3>Address</h3>
                        <p style="margin-top: 10px; line-height: 1.5;">
                            The Same Qualities Foundation (SQF),<br>
                            PSSSF PLOT # 153/1 Block KK OLORIEN,<br>
                            P.O. Box 11641,<br>
                            Arusha Tanzania</p>
                    </div>
                    <div class="section-heading mt-5 mt-lg-0 mb-4">
                        <h3>Ticket Info</h3>
                        <p style="margin-top: 10px; line-height: 1.5;">
                            Name: Peter Mabula <br>
                            Phone: +255 759 999 888 <br>
                            Email: info@samequalitiesfoundation.org</p>
                    </div>
                </div>
                <div class="col-xl-6 pe-xl-5 col-lg-6">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d63724.537490257484!2d36.64308074658419!3d-3.402894872306367!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x18370497ede0b813%3A0xb513ac0a12444521!2sIAA!5e0!3m2!1sen!2stz!4v1716994749510!5m2!1sen!2stz"
                        width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </section>
    <!-- end map section start -->
   
    <script>
        // client
        const clientSlider = document.getElementById('clientSlider');

        setInterval(() => {
            const firstClientBox = clientSlider.querySelector('.client-box');
            const clonedLogo = firstClientBox.cloneNode(true);
            clientSlider.appendChild(clonedLogo);
            clientSlider.removeChild(firstClientBox);
        }, 3000);

        function countdownTimer(targetDate) {
            const updateTimer = () => {
                const now = new Date().getTime();
                const distance = targetDate - now;

                if (distance < 0) {
                    clearInterval(interval);
                    document.querySelector('.countdown').innerHTML = "EXPIRED";
                    return;
                }

                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                document.getElementById("days").innerHTML = days;
                document.getElementById("hours").innerHTML = hours;
                document.getElementById("minutes").innerHTML = minutes;
                document.getElementById("seconds").innerHTML = seconds;
            };

            updateTimer();
            const interval = setInterval(updateTimer, 1000);
        }

        const targetDate = new Date("Dec 31, 2024 23:59:59").getTime();
        countdownTimer(targetDate);
    </script>


@endsection