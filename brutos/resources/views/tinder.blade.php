@extends('main')

@section('title', 'Login')

@section('conteudo')

<style>
    body {
        height: 100vh;
        width: 100vw;
        font-family: "Roboto", sans-serif;
        background: #6495ed2b;
        overflow: hidden;
        display: flex;
        align-content: center;
    }

    p {
        margin-bottom: 0;
    }

    .smartphone {
        display: flex;
        justify-content: flex-start;
        align-items: center;
        margin: auto;
        border-radius: 15px;
        width: clamp(290px, 49vh, 360px);
        height: clamp(580px, 98vh, 720px);
        border: 8px solid black;
    }

    .screen {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: space-around;
        width: 100%;
        height: 100%;
        background: rgb(255, 250, 250);
        border: 2px solid rgba(0, 0, 0, 0.15);
        border-radius: 7px;
    }

    .topbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 101.5%;
        padding: 2px 2%;
        position: relative;
        top: -2px;
        height: 20px;
        background: #838383;
        color: white;
        font-size: 15px;
        border-radius: 7px 7px 0 0;
        font-family: monospace;
    }

    .topbar-left {
        display: flex;
        align-items: center;
    }

    .topbar-middle {
        margin-left: 9px;
    }

    .topbar-middle::before {
        content: "";
        background: black;
        width: 10px;
        height: 50px;
        top: 248px;
        right: -11px;
        border-radius: 5px;
        position: absolute;
    }

    .clock {
        padding-right: 9px;
    }

    .camera {
        background: black;
        width: 54px;
        height: 10.2px;
        position: relative;
        top: 6.3px;
        border-radius: 0 0 20px 20px;
    }

    .camera::before {
        content: "";
        position: absolute;
        width: 31.7px;
        height: 16px;
        border-radius: 43%;
        top: 3.7px;
        left: -13.7px;
        background: #838383;
    }

    .camera::after {
        content: "";
        position: absolute;
        width: 31.7px;
        height: 16px;
        border-radius: 43%;
        top: 3.7px;
        left: 42.9px;
        background: #838383;
    }

    .camera-lens {
        background: black;
        width: 25px;
        height: 25px;
        top: -7px;
        left: 18px;
        border-radius: 50%;
        position: relative;
    }

    .camera-lens::before {
        content: "";
        position: absolute;
        width: 13px;
        height: 13px;
        border-radius: 50%;
        top: 7px;
        left: 6px;
        background: #2c3c3c;
    }

    .camera-lens::after {
        content: "";
        position: absolute;
        width: 3px;
        height: 12px;
        transform: rotate(45deg);
        top: 9.9px;
        left: 13.2px;
        background: #4056569e;
        border-radius: 0 20px 20px 0;
    }

    .inner-lens {
        position: relative;
        width: 5px;
        height: 5px;
        background: #565555a8;
        border-radius: 50%;
        top: -20.8px;
        left: 28px;
    }

    .inner-lens::after {
        content: "";
        position: absolute;
        width: 1.8px;
        height: 1.8px;
        transform: rotate(45deg);
        top: 1.6px;
        left: 1.6px;
        background: #00000085;
        border-radius: 50%;
    }

    .topbar-right {
        font-family: monospace;
    }

    .topbar-right::before {
        content: "";
        background: black;
        width: 10px;
        height: 140px;
        top: 80px;
        right: -11px;
        border-radius: 5px;
        position: absolute;
    }

    .topbar-right::after {
        content: "";
        background: #e4edfb;
        width: 10px;
        height: 12px;
        top: 149px;
        right: -19.3px;
        border-radius: 5px;
        position: absolute;
    }

    .screen footer {
        display: flex;
        align-items: center;
        justify-content: space-around;
        width: 102%;
        padding: 8px;
        margin-bottom: -2px;
        height: 25px;
        background: black;
        color: white;
        font-size: 15px;
    }

    .navbar {
        display: flex;
        justify-content: space-around;
        align-items: baseline;
        padding: 10px 0;
        width: 100%;
        height: 45px;
        pointer-events: none;
    }

    .person {
        width: 99%;
        height: 100%;
        background: #d6d5d5;
        border-radius: 10px;
    }

    .photo {
        margin: auto;
        height: 100%;
        border-radius: 10px;
        display: flex;
        align-items: flex-end;
        color: #eee;
        box-shadow: 0 2px 7px 0 rgba(136, 136, 136, 0.7);
        cursor: grab;
        transition: 300ms;
    }

    .photo.moving {
        transition: none;
        cursor: grabbing;
    }

    .photo.nope::after {
        content: "PASS";
        color: #f7e707;
        border: 6px solid #f7e707;
        border-radius: 8px;
        font-family: "Roboto", sans-serif;
        font-weight: 500;
        font-size: 3rem;
        padding: 0.2rem 0.4rem;
        position: absolute;
        top: 8%;
        right: 8%;
        transform: rotate(15deg);
    }

    .photo.super_like::after {
        content: "SUPER LIKE";
        color: #08a4ef;
        border: 6px solid #08a4ef;
        border-radius: 8px;
        font-family: "Roboto", sans-serif;
        text-align: center;
        font-weight: 500;
        font-size: 2.8rem;
        padding: 0.2rem 0.4rem;
        position: absolute;
        width: 150px;
        bottom: 10%;
        left: 24%;
        transform: rotate(-15deg);
    }

    .photo.like::after {
        content: "LIKE";
        color: #1be4a1;
        border: 6px solid #1be4a1;
        border-radius: 8px;
        font-family: "Roboto", sans-serif;
        font-weight: 500;
        font-size: 3rem;
        padding: 0.2rem 0.4rem;
        position: absolute;
        top: 8%;
        left: 8%;
        transform: rotate(-15deg);
    }

    .personal {
        padding: 10px;
        width: 100%;
        background: linear-gradient(180deg,
                rgba(0, 0, 0, 0) 0%,
                rgba(0, 0, 0, 0.5) 24%);
        border-radius: 10px;
        transition-duration: .5s;

        p {
            font-size: 14px;
            /* text-align: justify; */
        }
    }

    .name-age {
        display: flex;
        align-items: baseline;
        margin-bottom: 6px;
    }

    .name {
        font-size: 2rem;
        font-weight: 500;
    }

    .age {
        font-size: 1.6rem;
        margin-left: 10px;
        font-weight: 400;
    }

    .data p {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        max-height: 60px;
        /* Aproximadamente 3 linhas (1.5em por linha) */
        transition: max-height .6s ease;
    }

    /* Ao passar o mouse na div.person */
    .person:hover .data p {
        -webkit-line-clamp: unset;
        max-height: 500px;
        /* Um valor suficientemente grande */
        overflow: visible;
    }

    .person:hover .personal {
        background: linear-gradient(180deg,
                rgba(0, 0, 0, 0) 0%,
                rgba(0, 0, 0, 0.8) 24%);
    }


    .about {
        display: flex;
    }

    .about-icon,
    .about-text {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: flex-start;
    }

    .about-icon {
        align-items: center;
    }

    .about-text {
        align-items: flex-start;
        margin-left: 6px;
    }

    .about-icon i,
    .about-text p {
        padding: 4px 0;
    }

    /* Actions */
    .commands {
        width: 100%;
        display: flex;
        justify-content: space-around;
        align-items: center;
        height: 100px;
    }

    .command {
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fff;
        height: 60px;
        width: 60px;
        border-radius: 50%;
        font-size: 2rem;
        box-shadow: 0 2px 6px 0 rgba(112, 125, 134, 0.14);
        transition: 500ms ease;
        cursor: pointer;
    }

    .command i {
        transition: 500ms ease;
    }

    .command:hover {
        transform: scale(1.1);
        color: #fff;
        box-shadow: 0 2px 6px 0 rgba(112, 125, 134, 0.33);
    }

    .command:hover i {
        transform: scale(1.15);
    }

    .events-none {
        pointer-events: none;
    }

    /* icon size and colors */
    .fa-circle-user,
    .fa-comment-dots {
        color: #dadfe6;
        font-size: 1.5rem;
    }

    .fa-fire-flame-curved {
        color: #fe466d;
        font-size: 1.7rem;
    }

    .fa-circle-info {
        cursor: pointer;
        transition: 500ms ease;
    }

    .fa-circle-info:hover {
        transform: scale(1.1);
        color: #fff;
    }

    .fa-forward {
        color: #f7e707;
    }

    .fa-heart {
        color: #1be4a1;
    }
</style>


<div class="smartphone">
    <div class="screen">
        <div class="topbar">
            <div class="topbar-left">
                <div class="clock">00:00</div>
                <i class="fa fa-youtube-play"></i>
            </div>
            <div class="topbar-middle">
                <div class="camera"></div>
                <div class="camera-lens"></div>
                <div class="inner-lens"></div>
            </div>
            <div class="topbar-right">
                <i class="fa fa-signal"></i>
                73%
                <i class="fa fa-battery-three-quarters"></i>
            </div>
        </div>
        <nav class="navbar">
            <i class="fa-solid fa-circle-user"></i>
            <i class="fa-solid fa-fire-flame-curved"></i>
            <i class="fa-solid fa-comment-dots"></i>
        </nav>
        <div class="person">
            <figure class="photo">
                <div class="personal">
                    <div class="name-age">
                        <h2 class="name">Lorem</h2>
                        <h2 class="age">26</h2>
                    </div>
                    <div class="data">
                        <p>
                            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ab, quasi cum a voluptatibus eius eum temporibus? Voluptate quidem odio consectetur ea veniam debitis repellat aspernatur, molestiae reiciendis eaque quod perspiciatis. Lorem Ipsum d
                        </p>
                    </div>
                </div>
            </figure>
        </div>
        <div class="commands">
            <div class="command">
                <i class="fa-solid fa-forward"></i>
            </div>
            <div class="command">
                <i class="fa-solid fa-heart"></i>
            </div>
        </div>
        <footer>
            <i class="fa fa-reorder"></i>
            <i class="fa fa-square-o"></i>
            <i class="fa fa-chevron-left"></i>
        </footer>
    </div>
</div>

<script>
    // Gets the photo element
    var el = document.querySelector(".photo");
    var girlCount = 0;
    var girlLast = 5;
    // Creates the object
    var hammerTime = new Hammer(el);
    // Unlocks vertical pan and pinch
    hammerTime.get("pan").set({
        direction: Hammer.DIRECTION_ALL
    });
    hammerTime.get("pinch").set({
        enable: true
    });

    // When user grabs the photo..
    hammerTime.on("pan", function(ev) {
        // When the photo start moving, the transition become "none" to avoid delay while dragging
        el.classList.add("moving");
        // If the photo go 80px left/right, the "nope"/"like" stamp appears using css::after
        el.classList.toggle("nope", ev.deltaX < -80);
        el.classList.toggle("like", ev.deltaX > 80);
        el.classList.toggle(
            "super_like",
            (ev.deltaY < -72) & (Math.abs(ev.deltaX) < 80)
        );
        // Calculates photo rotation based on offset
        var rotate = ev.deltaX * ev.deltaY * 4e-4;
        // And applies the movement
        el.style.transform =
            "translate(" +
            ev.deltaX +
            "px, " +
            ev.deltaY +
            "px) rotate(" +
            rotate +
            "deg)";
    });

    // When user releases the photo..
    hammerTime.on("panend", function(ev) {
        // Gets the positive value of velocity and X-deslocation
        var absVel = Math.abs(ev.velocity);
        var absDelX = Math.abs(ev.deltaX);
        // Removes the stamps and retrieve the 300ms transition
        el.classList.remove("nope", "like", "super_like", "oops", "moving");
        if (absDelX > 80) {
            // If the photo had a "like"/"dislike" reaction
            // Photo fades faster if dragged faster, beetwen 400 and 150ms
            var transitionDuration =
                250 / (absVel + 0.4) > 150 ?
                250 / (absVel + 0.4) > 400 ?
                400 :
                250 / (absVel + 0.4) :
                150;
            el.style.transitionDuration = transitionDuration + "ms";
            var rotate = ev.deltaX * ev.deltaY * 4e-4;
            // And is thrown farther too
            var mult = absVel > 1.4 ? absVel : 1.4;
            el.style.transform =
                "translate(" +
                ev.deltaX * 1.4 * mult +
                "px, " +
                ev.deltaY * mult +
                "px) rotate(" +
                rotate * mult +
                "deg)";
            // Fade out
            el.style.opacity = 0;
            // And the photo returns
            repeat(transitionDuration);
        } else if (ev.deltaY < -72) {
            // If the photo had a "super like" reaction, very similar code to the previous one
            var transitionDuration =
                250 / (absVel + 0.4) > 150 ?
                250 / (absVel + 0.4) > 400 ?
                400 :
                250 / (absVel + 0.4) :
                150;
            el.style.transitionDuration = transitionDuration + "ms";
            var mult = absVel > 2 ? absVel : 2;
            el.style.transform = "translate( 0px, " + ev.deltaY * mult + "px)";
            el.style.opacity = 0;
            repeat(transitionDuration);
        } else {
            // If the photo didn't have a reaction, it goes back to the middle
            el.style.transform = "";
        }
    });

    hammerTime.on("pinch", function(ev) {
        el.style.transitionDuration = "0ms";
        el.style.transform = "scale(" + ev.scale + ")";
    });

    hammerTime.on("pinchend", function() {
        el.style.transform = "scale(1)";
    });

    // The function that brings back the photo
    function repeat(transitionDuration = 350) {
        setTimeout(function() {
            el.style.transform = "";
            setTimeout(function() {
                el.classList.remove("nope", "like", "super_like", "oops", "moving");
                el.style.opacity = 1;
                setTimeout(function() {
                    // Reactivates the buttons with a slight delay so that the photo has time to be recognized
                    document
                        .querySelector(".commands")
                        .classList.remove("events-none");
                }, 140);
            }, transitionDuration);
            switchingPeople();
        }, transitionDuration);
    }

    function switchingPeople() {
        girlCount == girlLast ? (girlCount = 1) : girlCount++;
        document.querySelector(".photo").style.background =
            "url('../assets/tinderImgs/girl" + girlCount + ".jpeg') center center/cover";
        switch (girlCount) {
            case 1:
                document.querySelector(".name").innerHTML = "Lorem";
                document.querySelector(".age").innerHTML = "26";
                document.querySelector(".ocupation").innerHTML = "Designer";
                document.querySelector(".work").innerHTML = "Stanford University";
                document.querySelector(".distance").innerHTML = "3 miles away";
                break;
            case 2:
                document.querySelector(".name").innerHTML = "Ipsum";
                document.querySelector(".age").innerHTML = "31";
                document.querySelector(".ocupation").innerHTML = "Lawyer";
                document.querySelector(".work").innerHTML = "Stanford University";
                document.querySelector(".distance").innerHTML = "4 miles away";
                break;
            case 3:
                document.querySelector(".name").innerHTML = "Dolor";
                document.querySelector(".age").innerHTML = "32";
                document.querySelector(".ocupation").innerHTML = "Engineer";
                document.querySelector(".work").innerHTML = "Stanford Engineering";
                document.querySelector(".distance").innerHTML = "4 miles away";
                break;
            case 4:
                document.querySelector(".name").innerHTML = "Sit";
                document.querySelector(".age").innerHTML = "29";
                document.querySelector(".ocupation").innerHTML = "Doctor";
                document.querySelector(".work").innerHTML = "Stanford Medicine";
                document.querySelector(".distance").innerHTML = "5 miles away";
                break;
        }
    }

    // The reactions animation
    function buttonEvent(reaction) {
        // Random transition duration beetwen 300ms and 600ms
        var transitionDuration = Math.random() * 300 + 300;
        // Random X-deslocation beetwen 100px and 400px
        var x = Math.random() * 300 + 100;
        // Random Y-deslocation beetwen -200px and 200px
        var y = Math.random() * 400 - 200;
        var rotate = x * y * 4e-4;
        // Prevents giving new command before current one is finished
        document.querySelector(".commands").classList.add("events-none");
        if (reaction == "like") {
            // If the reaction was a "like", stamps "like"
            el.classList.add("like");
        } else if (reaction == "dislike") {
            // If the reaction was a "dislike", stamps "nope" and moves the photo to the left
            el.classList.add("nope");
            x *= -1;
        }

        el.style.transitionDuration = transitionDuration + "ms";
        el.style.transform =
            "translate(" + x + "px, " + y + "px) rotate(" + rotate + "deg)";
        el.style.opacity = 0;
        repeat(transitionDuration * 0.8);
    }

    // Creates button actions
    document
        .querySelector(".fa-forward")
        .parentNode.addEventListener("click", function() {
            buttonEvent("dislike");
        });

    document
        .querySelector(".fa-heart")
        .parentNode.addEventListener("click", function() {
            buttonEvent("like");
        });

    // Clock
    var clockTicking = setInterval(clock, 1000);

    function clock() {
        var d = new Date(),
            displayDate;
        displayDate = d.toLocaleTimeString();
        document.querySelector(".clock").innerHTML = displayDate.substring(0, 5);
    }

    switchingPeople();
</script>

@endsection