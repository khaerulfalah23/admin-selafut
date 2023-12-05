<div class="login">
         <img src="<?= base_url('assets/autentifikasi/img/login-bg.png'); ?>" alt="image" class="login__bg">
         <div class="pesan" title="Login tidak berhasil" data-flashdata="<?= $this->session->flashdata('pesan'); ?>">
         <div class="pesan-logout" title="Anda berhasil logout!" data-flashdata="<?= $this->session->flashdata('logout'); ?>"></div>
         <form action="<?= base_url('autentifikasi'); ?>" method="post" class="login__form">
            <h1 class="login__title">Login</h1>
            <div class="login__inputs">
                <div>
                  <div class="login__box">
                    <input type="text" id="email" name="email" value="<?= set_value('email'); ?>" placeholder="Email" class="login__input">
                    <i class="ri-mail-fill"></i>
                  </div>
                  <?= form_error('email', '<small class="login__check-label" style="padding-left: 23px; color: black; font-weight: bold;">', '</small>'); ?>
                </div>
              
               <div>
                 <div class="login__box">
                    <input type="password" name="password" placeholder="Password" class="login__input">
                    <i class="ri-lock-2-fill"></i>
                 </div>
                 <?= form_error('password', '<small class="login__check-label" style="padding-left: 23px; color: black; font-weight: bold;">', '</small>'); ?>
               </div>
            </div>

            <div class="login__check">
               <div class="login__check-box">
                  <input type="checkbox" class="login__check-input" id="user-check">
                  <label for="user-check" class="login__check-label">Remember me</label>
               </div>

               <a href="" class="login__forgot">Forgot Password?</a>
            </div>

            <button type="submit" class="login__button">Login</button>

         </form>
         </div>
      </div>