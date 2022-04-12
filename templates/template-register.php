<?php
/**
 * The template for the root register page
 *
 * Template Name: Register [Root]
 *
 * @package Rookie
 */

get_header(); ?>


<link rel="stylesheet" href="/htdocs/wp-content/plugins/tecschoolesports/styles/register.css">
<div id="primary" class="content-area content-area-full-width">

<div class="tecbg"></div>

    <main id="main" class="site-main" role="main">
        <div class="textwrapper">
            <h2 class="large-h">Our Vision</h2>
            <hr class="underline">
            <p class="lowtext">To provide career readiness and job opportunities to future generations</p>
        </div>

        <div class="missionwrapper mtop-50">
            <div class="textwrapper">
                <h2 class="large-h">Our Mission</h2>
                <hr class="underline">
                <p class="lowtext">Create the Minor League system for Esports using a 3 pronged approach:</p>
            </div>

            <div class="contentboxwrapper mtop-50">
                <div class="titlecont">
                    <div class="titlecont-img">
                        <img src="https://tecschoolesports.com/htdocs/wp-content/plugins/tecschoolesports/images/technology.png">
                    </div>
                    <div class="titlecont-h">
                        <h2>Technology</h2>
                    </div>
                </div>

                <div class="titlecont">
                    <div class="titlecont-img">
                        <img src="https://tecschoolesports.com/htdocs/wp-content/plugins/tecschoolesports/images/education.png">
                    </div>
                    <div class="titlecont-h">
                        <h2>Education</h2>
                    </div>
                </div>

                <div class="titlecont">
                    <div class="titlecont-img">
                        <img src="https://tecschoolesports.com/htdocs/wp-content/plugins/tecschoolesports/images/community.png">
                    </div>
                    <div class="titlecont-h">
                        <h2>Community</h2>
                    </div>
                </div>
            </div>

            <div class="textwrapper mtop-50">
                <h2 class="large-h">Games We Offer</h2>
                <hr class="underline">
            </div>

            <div class="contentboxwrapper-4">
                <div class="schoolbox" id="knockoutcity-box" onmouseover="imghover('i-knockoutcity');" onmouseleave="imgleave('i-knockoutcity');">
                    <div class="schoolbox-image knockoutcity">
                        <img src="https://tecschoolesports.com/wp-content/uploads/2021/12/koc.png" alt="Knockout City" id="i-knockoutcity" class="schoolbox-image-img">
                    </div>
                    <div class="schoolbox-title"><p>Knockout City</p></div>
                </div>

                <div class="schoolbox" id="overwatch-box" onmouseover="imghover('i-overwatch');" onmouseleave="imgleave('i-overwatch');">
                    <div class="schoolbox-image overwatch">
                        <img src="https://tecschoolesports.com/wp-content/uploads/2021/10/tec-ov-e1642548358670.png" alt="Overwatch" id="i-overwatch" class="schoolbox-image-img">
                    </div>
                    <div class="schoolbox-title"><p>Overwatch</p></div>
                </div>

                
                <div class="schoolbox" id="rocketleague-box" onmouseover="imghover('i-rocketleague');" onmouseleave="imgleave('i-rocketleague');">
                    <div class="schoolbox-image rocketleague">
                        <img src="https://tecschoolesports.com/wp-content/uploads/2022/03/tec-rl.png" alt="Rocket League" id="i-rocketleague" class="schoolbox-image-img">
                    </div>
                    <div class="schoolbox-title"><p>Rocket League</p></div>
                </div>

                
                <div class="schoolbox" id="valorant-box" onmouseover="imghover('i-valorant');" onmouseleave="imgleave('i-valorant');">
                    <div class="schoolbox-image valorant">
                        <img src="https://tecschoolesports.com/wp-content/uploads/2022/03/tecva.png" alt="Valorant" id="i-valorant" class="schoolbox-image-img">
                    </div>
                    <div class="schoolbox-title"><p>Valorant D1</p></div>
                </div>
            </div>

            <div class="textwrapper mtop-50">
                <h2 class="large-h">Register Now!</h2>
                <hr class="underline">
            </div>

            <div class="contentwrapper-2 mtop-50">
                <div class="regbox">
                    <p class="lowtext">Students</p>
                    <button id="studentreg" class="hollowbtn">Sign Up</button>
                </div>
                <div class="regbox mtop-50">
                    <p class="lowtext">Team Managers</p>
                    <button id="tmreg" class="hollowbtn">Sign Up</button>
                </div>
            </div>
        </div>
    </main>
</div>