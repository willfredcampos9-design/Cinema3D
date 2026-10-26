@extends('layout')
@section('title', 'Reserva de boletas')

@section('content')
{{-- ========== PASO 2: contenedor general, título y subtítulo ========== --}}
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="page-title text-center mb-3">Reserva de boletas</h1>
            <p class="page-subtitle text-center mb-5">
                Elige tu película, el formato de proyección y tus snacks favoritos.
            </p>

            {{-- Mensajes de éxito / error del guardado (los llena el JS del Paso 6) --}}
            <div id="alertaEstado" class="alert d-none" role="alert"></div>

            {{-- ========== PASO 3 y 4: formulario (campos en _form.blade.php) ========== --}}
            <div class="card cine-card">
                <div class="card-body p-4">
                    <form id="formularioBootstrap" action="{{ route('reservas.store') }}" method="POST">
                        @csrf
                        @include('reservas._form', ['reserva' => null])

                        <!-- Botón de Envío -->
                        <div class="d-grid">
                            <button type="submit" id="btnEnviar" class="btn btn-primary btn-lg">
                                Reservar y mostrar boleta
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- ========== PASO 5: zona de resultados (oculta hasta enviar) ========== --}}
            <div id="resultados" class="mt-5" style="display: none;">
                <div class="card cine-card results-card">
                    <div class="card-header">
                        <h5 class="mb-0">🎟️ Resumen de tu reserva</h5>
                    </div>
                    <div class="card-body" id="contenidoResultados"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
{{-- ========== PASO 6: lógica JavaScript (captura, guardado y visualización) ========== --}}
<script>
    const formulario = document.getElementById('formularioBootstrap');
    const boton = document.getElementById('btnEnviar');
    const alerta = document.getElementById('alertaEstado');

    function mostrarAlerta(tipo, mensajes) {
        alerta.className = `alert alert-${tipo}`;
        alerta.replaceChildren(...mensajes.map(m => {
            const linea = document.createElement('div');
            linea.textContent = m;
            return linea;
        }));
    }

    formulario.addEventListener('submit', async function (e) {
        e.preventDefault(); // Previene la recarga de la página
        boton.disabled = true;
        alerta.classList.add('d-none');

        // 1) Guardar en la base de datos (Laravel valida y responde JSON)
        try {
            const respuesta = await fetch(formulario.action, {
                method: 'POST',
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                body: new FormData(formulario) // incluye el token @csrf
            });
            const datos = await respuesta.json();

            if (!respuesta.ok) {
                const errores = datos.errors
                    ? Object.values(datos.errors).flat()
                    : [datos.message ?? 'No se pudo guardar la reserva.'];
                mostrarAlerta('danger', errores);
                return;
            }
            mostrarAlerta('success', [datos.message]);
        } catch (error) {
            mostrarAlerta('danger', ['No fue posible guardar. Recargue la página e intente de nuevo.']);
            return;
        } finally {
            boton.disabled = false;
        }

        // 2) Captura de valores
        const nombres = document.getElementById('nombres').value;
        const apellidos = document.getElementById('apellidos').value;
        const selectPelicula = document.getElementById('pelicula');
        const pelicula = selectPelicula.options[selectPelicula.selectedIndex].text.trim();
        const fecha = document.getElementById('fechaFuncion').value;
        const boletas = document.getElementById('boletas').value;
        const formato = document.querySelector('input[name="formato"]:checked').value;
        const estudiante = document.querySelector('input[name="estudiante"]:checked').value;

        // Captura de múltiples checkboxes (se muestra el texto del label, no el id)
        const snacksSeleccionados = [];
        document.querySelectorAll('input[name="snacks[]"]:checked').forEach(cb => {
            snacksSeleccionados.push(cb.nextElementSibling.textContent.trim());
        });

        const snacksTexto = snacksSeleccionados.length > 0
            ? snacksSeleccionados.join(', ') : 'Ninguno seleccionado';

        // 3) Estructura de datos a presentar
        const respuestas = [
            ['Nombres', nombres],
            ['Apellidos', apellidos],
            ['Película', pelicula],
            ['Fecha de la función', fecha],
            ['Cantidad de boletas', boletas],
            ['Formato de proyección', formato],
            ['Carné de estudiante', estudiante],
            ['Snacks', snacksTexto]
        ];

        // 4) Renderizado dinámico en el DOM
        const contenidoResultados = document.getElementById('contenidoResultados');
        contenidoResultados.replaceChildren(...respuestas.map(([etiqueta, valor]) => {
            const parrafo = document.createElement('p');
            const titulo = document.createElement('strong');
            titulo.textContent = `${etiqueta}:`;
            parrafo.append(titulo, ` ${valor}`);
            return parrafo;
        }));

        // 5) Muestra el contenedor y desplaza la vista hacia los resultados
        document.getElementById('resultados').style.display = 'block';
        document.getElementById('resultados').scrollIntoView({ behavior: 'smooth' });
    });
</script>
@endsection
