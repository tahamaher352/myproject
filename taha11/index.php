<?php

$winner = null;
$users = [];
$errors = [];

// الاتصال بقاعدة البيانات
require_once './inc/db.php';

// معالجة النموذج
require_once './inc/form.php';

// جلب المسجلين
require_once './inc/select.php';

// اختيار فائز عشوائي من المسجلين
if (!empty($users) && is_array($users)) {
    $winner = $users[array_rand($users)];
}

?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>التسجيل</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css"
        rel="stylesheet"
        integrity="sha384-CfCrinSRH2IR6a4e6fy2q6ioOX7O6Mtm1L9vRvFZ1trBncWmMePhzvafv7oIcWiW"
        crossorigin="anonymous"
    >

    <link rel="stylesheet" href="./css/style.css">

    <style>

        body {
            background-color: #fff;
        }

        .loader-con {
            display: none;
            text-align: center;
            margin: 30px auto;
        }

        #loader {
            display: inline-block;
        }

        #circularLoader {
            max-width: 100%;
            height: auto;
        }

        #winnerResult {
            margin-top: 30px;
            min-height: 150px;
        }

        .winner-box {
            padding: 30px;
            border-radius: 20px;
            background: #f8f9fa;
            border: 2px solid #4285f4;
            animation: winnerAppear 0.8s ease;
        }

        .winner-box h2,
        .winner-box h1 {
            margin-bottom: 15px;
        }

        @keyframes winnerAppear {

            from {
                opacity: 0;
                transform: scale(0.5);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }

        }

        #confettiCanvas {
            position: fixed;
            inset: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 9999;
        }

        .error {
            color: red;
        }

        .users-count {
            margin-bottom: 20px;
            font-weight: bold;
        }

    </style>

</head>

<body>

<div class="container">

    <!-- المقدمة -->

    <div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center bg-light">

        <div class="col-md-8 p-lg-5 mx-auto my-5">

            <h1 class="display-4 fw-normal">
                التسجيل
            </h1>

            <p class="lead fw-normal">
                قم بتسجيل بياناتك للمشاركة
                <br>
               ( الرجاء قراءة الشروط بتمعن حتى لاتتم ازالتك من المسابقه)
            </p>

            <h3 id="demo"></h3>

        </div>

    </div>


    <!-- المعلومات -->
<ul class="list-group">

  <li class="list-group-item list-group-item-primary">الرجاء تسجيل الاسم الاول</li>
  <li class="list-group-item list-group-item-secondary">الرجاء تسجيل الاسم الثاني</li>
  <li class="list-group-item list-group-item-success">الرجاء تسجيل البريد الالكتروني</li>
  <li class="list-group-item list-group-item-danger">يجب الموافقه على شروط المسابقه</li>
  <li class="list-group-item list-group-item-warning">سيتم الاختيار الفائز بشكل عشوائي</li>
  
</ul>

    <!-- نموذج التسجيل -->

    <div class="position-relative text-right">

        <div class="col-md-6 p-lg-5 mx-auto my-5">

            <form
                action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'); ?>"
                method="POST"
            >

                <h3 class="mb-4">
                    ادخل بياناتك
                </h3>


                <!-- الاسم الأول -->

                <div class="mt-4">

                    <label for="firstName" class="form-label">
                        الاسم الأول
                    </label>

                    <input
                        type="text"
                        name="firstName"
                        class="form-control"
                        id="firstName"
                        value="<?php echo htmlspecialchars($_POST['firstName'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                    >

                    <div class="form-text error">
                        <?php echo htmlspecialchars($errors['firstNameError'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
                    </div>

                </div>


                <!-- الاسم الثاني -->

                <div class="mt-4">

                    <label for="lastName" class="form-label">
                        الاسم الثاني
                    </label>

                    <input
                        type="text"
                        name="lastName"
                        class="form-control"
                        id="lastName"
                        value="<?php echo htmlspecialchars($_POST['lastName'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                    >

                    <div class="form-text error">
                        <?php echo htmlspecialchars($errors['lastNameError'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
                    </div>

                </div>


                <!-- البريد -->

                <div class="mt-4">

                    <label for="email" class="form-label">
                        البريد الإلكتروني
                    </label>

                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        id="email"
                        value="<?php echo htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                    >

                    <div class="form-text error">
                        <?php echo htmlspecialchars($errors['emailError'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
                    </div>

                </div>


                <!-- الشروط -->

                <div class="mb-3 mt-4 form-check">

                    <input
                        type="checkbox"
                        name="terms"
                        value="1"
                        class="form-check-input"
                        id="exampleCheck1"
                    >

                    <label
                        class="form-check-label"
                        for="exampleCheck1"
                    >
                   هل انت موافق على شروطنا؟
                    </label>

                    <div class="form-text error">
                        <?php echo htmlspecialchars($errors['termsError'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
                    </div>

                </div>


                <!-- زر التسجيل -->

                <button
                    type="submit"
                    name="submit"
                    class="btn btn-primary"
                >
                    تسجيل
                </button>

            </form>

        </div>

    </div>


    <!-- عدد المسجلين -->

    <div class="text-center users-count">

        عدد المسجلين:

        <span class="badge bg-primary">
            <?php echo count($users); ?>
        </span>

    </div>


    <!-- Loader -->

    <div class="loader-con" id="loaderContainer">

        <div id="loader">

            <canvas
                id="circularLoader"
                width="200"
                height="200"
            ></canvas>

        </div>

    </div>


    <!-- زر اختيار الفائز -->

    <div class="col-12 text-center mb-3">

        <button
            id="winner"
            type="button"
            class="btn btn-primary"
            <?php echo empty($users) ? 'disabled' : ''; ?>
        >
            اختيار الفائز
        </button>

    </div>


    <!-- نتيجة الفائز -->

    <div
        id="winnerResult"
        class="text-center mb-5"
    ></div>


    <!-- المسجلين -->

    <div id="cards" class="row mb-5 pb-5">

        <?php if (!empty($users)): ?>

            <?php foreach ($users as $user): ?>

                <div class="col-sm-6 col-md-4">

                    <div class="card my-2 bg-light">

                        <div class="card-body">

                            <h5 class="card-title">

                                <?php

                                echo htmlspecialchars(
                                    ($user['firstName'] ?? '') . ' ' . ($user['lastName'] ?? ''),
                                    ENT_QUOTES,
                                    'UTF-8'
                                );

                                ?>

                            </h5>

                            <p class="card-text">

                                <?php

                                echo htmlspecialchars(
                                    $user['email'] ?? '',
                                    ENT_QUOTES,
                                    'UTF-8'
                                );

                                ?>

                            </p>

                        </div>

                    </div>

                </div>

            <?php endforeach; ?>

        <?php else: ?>

            <div class="col-12 text-center">

                <p class="text-muted">
                    لا يوجد مسجلين حتى الآن
                </p>

            </div>

        <?php endif; ?>

    </div>


</div>


<!-- Confetti -->

<canvas id="confettiCanvas"></canvas>


<!-- JavaScript -->

<script src="./js/script.js"></script>


<script>

const canvas = document.getElementById('circularLoader');
const ctx = canvas.getContext('2d');

const loaderContainer = document.getElementById('loaderContainer');
const winnerButton = document.getElementById('winner');
const winnerResult = document.getElementById('winnerResult');

let al = 0;

const start = -Math.PI / 2;

const cw = canvas.width;
const ch = canvas.height;

let sim = null;


/*
|--------------------------------------------------------------------------
| بيانات الفائز القادمة من PHP
|--------------------------------------------------------------------------
*/

const winnerData = <?php

    if ($winner) {

        echo json_encode(
            [
                'firstName' => $winner['firstName'] ?? '',
                'lastName'  => $winner['lastName'] ?? '',
                'email'     => $winner['email'] ?? ''
            ],
            JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP
        );

    } else {

        echo 'null';

    }

?>;


/*
|--------------------------------------------------------------------------
| الضغط على زر اختيار الفائز
|--------------------------------------------------------------------------
*/

winnerButton.addEventListener('click', function () {

    if (!winnerData) {

        winnerResult.innerHTML = `
            <div class="alert alert-warning">
                لا يوجد مسجلين لاختيار فائز منهم.
            </div>
        `;

        return;

    }

    winnerButton.disabled = true;

    loaderContainer.style.display = 'block';

    winnerResult.innerHTML = '';

    al = 0;

    ctx.clearRect(0, 0, cw, ch);

    sim = setInterval(progressSim, 50);

});


/*
|--------------------------------------------------------------------------
| Progress
|--------------------------------------------------------------------------
*/

function progressSim() {

    const diff = (al / 100) * Math.PI * 2;

    ctx.clearRect(0, 0, cw, ch);

    ctx.lineWidth = 17;

    ctx.strokeStyle = '#00d9ff';

    ctx.textAlign = 'center';

    ctx.font = '28px monospace';

    ctx.fillStyle = '#000';

    ctx.fillText(
        al + '%',
        cw / 2,
        ch / 2 + 10
    );


    ctx.beginPath();

    ctx.arc(
        cw / 2,
        ch / 2,
        75,
        start,
        diff + start,
        false
    );

    ctx.stroke();


    if (al >= 100) {

        clearInterval(sim);

        loaderContainer.style.display = 'none';

        showWinner();

        return;

    }

    al++;

}


/*
|--------------------------------------------------------------------------
| إظهار الفائز
|--------------------------------------------------------------------------
*/

function showWinner() {

    if (!winnerData) {

        winnerResult.innerHTML = `
            <div class="winner-box">

                <h2>
                    لا يوجد مسجلين
                </h2>

            </div>
        `;

        return;

    }


    const fullName =
        `${winnerData.firstName} ${winnerData.lastName}`.trim();


    winnerResult.innerHTML = `

        <div class="winner-box">

            <h2>🎉 مبروك 🎉</h2>

            <h1>
                الفائز
            </h1>

            <h2 id="winnerName"></h2>

            <p class="mt-3">
                ${escapeHtml(winnerData.email)}
            </p>

        </div>

    `;


    document.getElementById('winnerName').textContent = fullName;

    confettiEffect();

}


/*
|--------------------------------------------------------------------------
| حماية عرض البيانات
|--------------------------------------------------------------------------
*/

function escapeHtml(text) {

    const div = document.createElement('div');

    div.textContent = text ?? '';

    return div.innerHTML;

}


/*
|--------------------------------------------------------------------------
| Confetti
|--------------------------------------------------------------------------
*/

function confettiEffect() {

    const confettiCanvas =
        document.getElementById('confettiCanvas');

    const confettiCtx =
        confettiCanvas.getContext('2d');


    confettiCanvas.width = window.innerWidth;

    confettiCanvas.height = window.innerHeight;


    const pieces = [];


    const colors = [

        '#ff4d6d',
        '#ffd166',
        '#1d6451',
        '#bfd3da',
        '#8338ec',
        '#00d9ff'

    ];


    for (let i = 0; i < 150; i++) {

        pieces.push({

            x:
                Math.random() *
                confettiCanvas.width,

            y:
                -20 -
                Math.random() *
                confettiCanvas.height,

            w:
                8 +
                Math.random() * 8,

            h:
                8 +
                Math.random() * 8,

            color:
                colors[
                    Math.floor(
                        Math.random() *
                        colors.length
                    )
                ],

            speed:
                2 +
                Math.random() * 4,

            rotation:
                Math.random() *
                Math.PI *
                2,

            rotationSpeed:
                (Math.random() - 0.5) *
                0.2

        });

    }


    const startTime = Date.now();

    const duration = 5000;


    function animateConfetti() {

        const elapsed =
            Date.now() -
            startTime;


        confettiCtx.clearRect(
            0,
            0,
            confettiCanvas.width,
            confettiCanvas.height
        );


        for (let i = 0; i < pieces.length; i++) {

            const p = pieces[i];


            p.y += p.speed;

            p.rotation += p.rotationSpeed;


            confettiCtx.save();

            confettiCtx.translate(
                p.x,
                p.y
            );

            confettiCtx.rotate(
                p.rotation
            );

            confettiCtx.fillStyle =
                p.color;


            confettiCtx.fillRect(

                -p.w / 2,
                -p.h / 2,
                p.w,
                p.h

            );


            confettiCtx.restore();

        }


        if (elapsed < duration) {

            requestAnimationFrame(
                animateConfetti
            );

        } else {

            confettiCtx.clearRect(
                0,
                0,
                confettiCanvas.width,
                confettiCanvas.height
            );

        }

    }


    animateConfetti();

}


/*
|--------------------------------------------------------------------------
| تحديث حجم الكونفيتي عند تغيير حجم الشاشة
|--------------------------------------------------------------------------
*/

window.addEventListener('resize', function () {

    const confettiCanvas =
        document.getElementById('confettiCanvas');

    confettiCanvas.width =
        window.innerWidth;

    confettiCanvas.height =
        window.innerHeight;

});

</script>


<!-- Bootstrap JavaScript -->

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwxH9JrCjz..."
    crossorigin="anonymous"
></script>

</body>

</html>
