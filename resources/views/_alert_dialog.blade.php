<style>
    #alertDialog {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #fff;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        z-index: 1000;

        min-width: 400px;

    }

    .card-footer button {
        width: 100px;
    }

    .card-footer {
        display: flex;
        justify-content: center
    }
</style>

<div id="alertDialog" class="card" style="display: none;">
    <div class="card-header">
        <h3 id="alertTitle"></h3>
    </div>
    <div class="card-body">
        <p id="alertContent"></p>
    </div>
    <div class="card-footer"><button class="btn btn-primary" id="alertOKButton">OK</button></div>

</div>
