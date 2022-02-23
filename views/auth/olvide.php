<div class="contenedor olvide">
<?php include_once __DIR__ . '/../templates/nombre-sitio.php' ?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Reestablece tu Password</p>

        <?php include_once __DIR__ . '/../templates/alertas.php' ?>

        <form action="/olvide" method="POST" class="formulario">

            <div class="campo">
                <label for="email">Email</label>
                <input 
                    type="email"
                    id="email"
                    placeholder="Tu Email"
                    name="email"
                />
            </div>

            <input type="submit" value="Reestablecer Password" class="boton">

            <div class="acciones">
                <a href="/">¿Ya tienes una cuenta? Inicia Sesion</a>
                <a href="/crear">¿Aun no tienes una cuenta? Obtener una</a>
            </div>

        </form>
    </div>
</div>