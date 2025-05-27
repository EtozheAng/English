 <!-- resources/views/layouts/footer.blade.php -->
 <footer class="footer">
     <div class="container">
         <div class="footer__content">
             <!-- Логотип (можно вставить SVG или картинку) -->
             <div class="logo">
                 <a href="{{ url('/') }}">
                     <x-application-logo />
                 </a>
             </div>

             <!-- Ссылки на страницы -->
             <nav class="footer__nav">
                 <ul>
                     <li><a href="{{ route('home') }}">Главная</a></li>
                     <li><a href="{{ route('about') }}">О нас</a></li>
                     <li><a href="{{ route('alphabet') }}">Курсы</a></li>
                 </ul>
             </nav>

             <!-- Социальные сети -->
             <div class="footer__social">
                 <a href="#" class="footer__social-link">Facebook</a>
                 <a href="#" class="footer__social-link">Twitter</a>
                 <a href="#" class="footer__social-link">Instagram</a>
             </div>
         </div>
     </div>

     <div class="footer__bottom">
         <p>&copy; {{ date('Y') }} Ваша компания. Все права защищены.</p>
     </div>
 </footer>
