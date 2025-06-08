const header = document.querySelector("header");
const footer = document.querySelector("footer");


header.innerHTML = `
                <div class="main-header">
        <div class="logo">
            <h2>KOLOG-7</h2>
        </div>
        <form class="search">
            <button>
                <svg width="17" height="16" fill="none" xmlns="http://www.w3.org/2000/svg" role="img"
                    aria-labelledby="search">
                    <path d="M7.667 12.667A5.333 5.333 0 107.667 2a5.333 5.333 0 000 10.667zM14.334 14l-2.9-2.9"
                        stroke="currentColor" stroke-width="1.333" stroke-linecap="round" stroke-linejoin="round">
                    </path>
                </svg>
            </button>
            <input class="input" placeholder="Buscar..." required="" type="text">
            <button class="reset" type="reset">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </form>
        <div class="login">
            <a href="/login" class="button-17">INICIAR SESION</a>
        </div>
    </div>

    <nav class="navbar">
        <ul>
            <li><a href="/">Inicio</a></li>
            <li><a href="/about">Sobre Nosotros</a></li>
            <li><a href="/tienda">Tienda</a></li>
            <li><a href="/catalogo">Catalogo</a></li>
            <li><a href="/museo">Museo Virtual</a></li>
        </ul>
    </nav>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap');

    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        font-family: 'Nunito', sans-serif;
        font-size: 1em;
    }

    /* Header */
    .logo h2 {
        font-size: clamp(1rem, 1.5vw, 2.5rem);
    }

    .main-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #a9a9a9;
        padding: 20px 60px;
        color: rgb(0, 0, 0);
    }

    .main-header .login {
        display: flex;
        align-items: center;
    }

    /* Navbar */
    .navbar ul {
        list-style: none;
        background-color: black;
        padding: 0%;
        margin: 0%;
        overflow: hidden;
        align-content: center;
        display: flex;
        justify-content: space-evenly;
        align-items: center;
        font-size: clamp(0.5rem, 1vw, 2rem);
    }

    .navbar a {
        color: white;
        text-decoration: none;
        padding: 15px;
        display: block;
        align-content: space-between;

    }

    .navbar a:hover {
        background-color: rgb(66, 66, 66);
    }

    .navbar li {
        float: left;
    }

    .button-17 {
        align-items: center;
        appearance: none;
        background-color: #fff;
        border-radius: 24px;
        border-style: none;
        box-shadow: rgba(0, 0, 0, .2) 0 3px 5px -1px, rgba(0, 0, 0, .14) 0 6px 10px 0, rgba(0, 0, 0, .12) 0 1px 18px 0;
        box-sizing: border-box;
        color: #3c4043;
        cursor: pointer;
        display: inline-flex;
        fill: currentcolor;
        font-family: "Google Sans", Roboto, Arial, sans-serif;
        font-size: clamp(0.5rem, 1vw, 2rem);
        font-weight: 500;
        height: 48px;
        justify-content: center;
        letter-spacing: .25px;
        line-height: normal;
        max-width: 100%;
        overflow: visible;
        padding: 2px 24px;
        position: relative;
        text-decoration: none;
        text-align: center;
        text-transform: none;
        transition: box-shadow 280ms cubic-bezier(.4, 0, .2, 1), opacity 15ms linear 30ms, transform 270ms cubic-bezier(0, 0, .2, 1) 0ms;
        user-select: none;
        -webkit-user-select: none;
        touch-action: manipulation;
        width: auto;
        will-change: transform, opacity;
        z-index: 0;
    }

    .button-17:hover {
        background: #F6F9FE;
        color: #174ea6;
    }

    .button-17:active {
        box-shadow: 0 4px 4px 0 rgb(60 64 67 / 30%), 0 8px 12px 6px rgb(60 64 67 / 15%);
        outline: none;
    }

    .button-17:focus {
        outline: none;
        border: 2px solid #4285f4;
    }

    .button-17:not(:disabled) {
        box-shadow: rgba(60, 64, 67, .3) 0 1px 3px 0, rgba(60, 64, 67, .15) 0 4px 8px 3px;
    }

    .button-17:not(:disabled):hover {
        box-shadow: rgba(60, 64, 67, .3) 0 2px 3px 0, rgba(60, 64, 67, .15) 0 6px 10px 4px;
    }

    .button-17:not(:disabled):focus {
        box-shadow: rgba(60, 64, 67, .3) 0 1px 3px 0, rgba(60, 64, 67, .15) 0 4px 8px 3px;
    }

    .button-17:not(:disabled):active {
        box-shadow: rgba(60, 64, 67, .3) 0 4px 4px 0, rgba(60, 64, 67, .15) 0 8px 12px 6px;
    }

    .button-17:disabled {
        box-shadow: rgba(60, 64, 67, .3) 0 1px 3px 0, rgba(60, 64, 67, .15) 0 4px 8px 3px;
    }

    /* styling of Input */
    .input {
        font-size: clamp(0.5rem, 1vw, 2rem);
        background-color: transparent;
        width: 100%;
        height: 100%;
        padding-inline: 0.5em;
        padding-block: 0.7em;
        border: none;
    }

    input:focus {
        outline: none;
    }

    /* close button shown when typing */
    input:not(:placeholder-shown)~.reset {
        opacity: 1;
        visibility: visible;
    }

    .search button {
        border: none;
        background: none;
        color: #8b8ba7;
    }

    /* styling of whole input container */
    .search {
        --timing: 1.1s;
        --width-of-input: 300px;
        --height-of-input: 50px;
        --border-height: 2px;
        --input-bg: #fff;
        --border-color: #000000;
        --border-radius: 30px;
        --after-border-radius: 1px;
        position: relative;
        width: var(--width-of-input);
        height: var(--height-of-input);
        display: flex;
        align-items: center;
        padding-inline: 0.8em;
        border-radius: var(--border-radius);
        transition: border-radius 0.5s ease;
        background: var(--input-bg, #fff);
    }

    /* styling of animated border */
    .search:before {
        content: "";
        position: absolute;
        background: var(--border-color);
        transform: scaleX(0);
        transform-origin: center;
        width: 100%;
        height: var(--border-height);
        left: 0;
        bottom: 0;
        border-radius: 1px;
        transition: transform var(--timing) ease;
    }

    /* Hover on Input */
    .search:focus-within {
        border-radius: var(--after-border-radius);
    }

    /* here is code of animated border */
    .search:focus-within:before {
        transform: scale(1);
    }

    /* styling of close button */
    /* == you can click the close button to remove text == */
    .reset {
        border: none;
        background: none;
        opacity: 0;
        visibility: hidden;
    }

    /* sizing svg icons */
    .search svg {
        width: 17px;
        margin-top: 3px;
    }
</style>
`;

footer.innerHTML = `
            <div class="custom-footer">
        <div class="footer-section">
            <h3>Contáctanos</h3>
            <ul>
                <li><a href="tel:+573041717245">+57 304 1717245</a></li>
                <li><a href="mailto:info@kolog.co">info@kolog.co</a></li>
                <li>
                    <a href="https://maps.app.goo.gl/Bh7oLzPqZ93RLhj7A" target="_blank" rel="noopener noreferrer">
                        Calle 29 # 70 - 77
                    </a>
                </li>
            </ul>
        </div>

        <div class="footer-section">
            <h3>Redes sociales</h3>
            <ul>
                <li>
                    <a href="https://www.facebook.com/kolog.co" target="_blank" rel="noopener noreferrer">
                        Facebook
                    </a>
                </li>
                <li>
                    <a href="https://www.instagram.com/kolog.co" target="_blank" rel="noopener noreferrer">
                        Instagram
                    </a>
                </li>
                <li>
                    <a href="https://www.youtube.com/@kolog.co" target="_blank" rel="noopener noreferrer">
                        YouTube
                    </a>
                </li>
                <li>
                    <a href="https://twitter.com/kolog_co" target="_blank" rel="noopener noreferrer">
                        X
                    </a>
                </li>
            </ul>
        </div>

        <div class="footer-section">
            <h3>Sitios de interés</h3>
            <ul>
                <li><a href="/catalogo">Catálogo</a></li>
                <li><a href="/tienda">Tienda</a></li>
                <li><a href="/museo-virtual">Museo virtual</a></li>
                <li><a href="/politicas-de-privacidad">Políticas de privacidad</a></li>
                <li><a href="/terminos-y-condiciones">Términos y condiciones</a></li>
            </ul>
        </div>
    </div>
    
        <style>
            .custom-footer {
                display: flex;
                justify-content: space-around;
                background-color: #0d0d0d;
                color: white;
                padding: 40px 20px;
            }

            .footer-section {
                flex: 1;
                max-width: 300px;
                padding: 0 15px;
                border-right: 1px solid #999;
            }

            .footer-section:last-child {
                border-right: none;
            }

            .footer-section h3 {
                font-size: 18px;
                margin-bottom: 15px;
                font-weight: bold;
            }

            a {
                text-decoration: none;
                color: white;
                transform: translateX(2px);
            }

            a:hover {
                color: red;
            }

            .footer-section ul {
                list-style: none;
                padding: 0;
                list-style: disc;
                padding-left: 20px;
            }

            .footer-section li {
                margin-bottom: 10px;
                display: flex;
                align-items: center;
                gap: 8px;
                margin-bottom: 10px;
                transition: color 0.3s ease, transform 0.2s ease;
                cursor: pointer;
            }

            .footer-section li::before {
                content: "●";
                /* Puedes cambiarlo por "•", "◦", "✔", etc. */
                margin-right: 8px;
                color: gray;
            }

            .footer-section li:hover {
                color: red;
                transform: translateX(2px);
            }
        </style>
`;