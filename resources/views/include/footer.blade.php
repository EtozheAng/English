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
                     <li><a href="{{ route('home') }}" class="menu-item">Главная</a></li>
                     <li><a href="{{ route('games') }}" class="menu-item">Игры</a></li>
                     <li><a href="{{ route('alphabet') }}" class="menu-item">Алфавит</a></li>
                     <li><a href="{{ route('dictionary') }}" class="menu-item">Словарь</a></li>
                 </ul>
             </nav>

             <!-- Социальные сети -->
             <div class="footer__social">
                 <a href="tel:+79956106808" class="footer__social-link">+7 (995) 610-68-08</a>
                 <a href="#" class="footer__social-link">Вконтакте</a>
                 <a href="#" class="footer__social-link">WhatsApp</a>
             </div>
         </div>
     </div>

     <div class="footer__bottom">
         <p>&copy; {{ date('Y') }} Дипломная работа. Все права защищены.</p>
     </div>
 </footer>
