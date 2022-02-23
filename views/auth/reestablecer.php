<div class="contenedor reestablecer">
<?php include_once __DIR__ . '/../templates/nombre-sitio.php' ?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Coloca tu Nuevo Password</p>

        <?php include_once __DIR__ . '/../templates/alertas.php' ?>

        <?php if($mostrar) { ?>

        <form method="POST" class="formulario">

            <div class="campo">
                <label for="password">Password</label>
                <input 
                    type="password"
                    id="password"
                    placeholder="Tu Password"
                    name="password"
                />
            </div>

            <input type="submit" value="Guardar Password" class="boton">

            <div class="acciones">
                <a href="/crear">¿Aun no tienes una cuenta? Obtener una</a>
                <a href="/olvide">¿Olvidaste tu Password?</a>
            </div>

        </form>

        <?php } ?>
    </div>
</div>