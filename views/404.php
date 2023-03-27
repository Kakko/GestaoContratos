<style>
    /* ############################# KeyFrames */

    @keyframes rollMonkey {
        from {
            -ms-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -webkit-transform: rotate(0deg);
            -o-transform: rotate(0deg);
            transform: rotate(0deg);
        }

        to {
            -ms-transform: rotate(720deg);
            -moz-transform: rotate(720deg);
            -webkit-transform: rotate(720deg);
            -o-transform: rotate(720deg);
            transform: rotate(720deg);
        }
    }

    @keyframes rainTrain {
        from {
            transform: translate(-1000px, 0%);
        }

        to {
            transform: translate(0px, 0%);
            box-shadow: none;
        }
    }

    @keyframes rollMonkeySmoke {
        from {}

        to {
            box-shadow: none;
        }
    }

    /* ############################# Geral*/

    #id_404 {
        font-family: 'Roboto', sans-serif;
        font-size: 14px;
        color: #2a3568;
    }

    /* ############################# 404 */

    .err404 {
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        display: flex;
        flex-direction: column;
    }

    .err404>div div {
        font-size: 150px;
        font-weight: bold;
    }

    .err404 div:nth-child(2) {
        font-size: 25px;
        font-weight: bold;
        margin-bottom: 4px;
    }

    .err404>div:nth-child(3) {
        font-size: 14px;
        color: #b8fbf8;
    }

    .monkeyB {
        animation: rollMonkey 2s 3;
        animation-fill-mode: forwards;
    }

    /* .railTrain:hover::after  {
    content: 'Huhuhuhu';
    background: #2E8433;
    border-radius: 5px;
    font-size: 16px;
    float: right;
    top: 0;
    left: 60%;
    position: absolute;
    color: black;
    height: 20%;
    width: 90%;
    text-align: center;
    line-height: 180%;
    border-top: 0.5em solid transparent;
    border-left: 1.0em solid #f6b829;
} */

    .railTrain {
        animation: rainTrain 2s;
        animation-fill-mode: forwards;
    }

    .rainTrainSmoke {
        width: 60%;
        animation: rollMonkeySmoke 2s;
        animation-fill-mode: forwards;
        box-shadow: -36px 5px 37px 17px rgb(222, 222, 222);
    }
</style>

<div style="margin: 0px; height: calc(100vh - 60px); background: linear-gradient(#5b8ca0, #1e3aff);">
    <div class="err404">
        <div style="display: flex;" id="id_404">
            <div style="margin-right: 10px;" class="err404">Erro 4</div>
            <div style="align-self: center; background: transparent; border-radius: 40%;" class="railTrain">
                <img style="height: 120px; align-self: center;" class="monkeyB" src="<?php echo BASE_URL; ?>assets/images/icons/logoMonkeyBranch.png" alt="">
                <div class="rainTrainSmoke">
                </div>
            </div>
            <div style="margin-left: 10px;" class="err404">4</div>
        </div>
        <div style="color: #b8fbf8;">Oops! Essa página não pode ser encontrada.</div>
        <div style="color: #96a0d0;">"I've never known any problem that couldn't be solved with a little nap."</div>
    </div>
</div>

    