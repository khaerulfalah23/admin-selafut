<div class="container">
            <div class="login__content">
                <img src="<?= base_url('assets/autentifikasi/'); ?>img/bg-auth.png" alt="login image" class="login__img">

                <form action="<?= base_url('autentifikasi'); ?>" method="post" class="login__form">
                    <div>
                        <h1 class="login__title">
                            <span>Login</span>
                            <?= $this->session->flashdata('pesan'); ?>
                        </h1>
                    </div>
                    
                    <div>
                        <div class="login__inputs">
                            <div>
                                <label for="email" class="login__label">Email</label>
                                <input type="text" placeholder="Masukan Email" id="email" name="email" class="login__input" value="<?= set_value('email'); ?>">
                                <?= form_error('email', '<small class="login__check-label">', '</small>'); ?>
                            </div>
    
                            <div>
                                <label for="input-pass" class="login__label">Password</label>
                                <div class="login__box">
                                    <input type="password" placeholder="Masukan Password" name="password" class="login__input" id="input-pass">
                                    <?= form_error('password', '<small class="login__check-label">', '</small>'); ?>
                                    <i class="ri-eye-off-line login__eye" id="input-icon"></i>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div>
                        <div class="login__buttons">
                            <a href="<?= base_url('autentifikasi/registrasi'); ?>" class="login__button login__button-ghost" style="text-decoration: none; text-align: center;">Registrasi</a>
                            <button type="submit" class="login__button">Login</button>
                        </div>

                        <a href="#" class="login__forgot">Forgot Password?</a>
                    </div>
                </form>
            </div>
        </div>