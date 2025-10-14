<div>
    <div class="logo-section">
        <div class="coffee-icon"></div>
        <h1 class="brand-name">COFFEE GÓC ẢNH</h1>
    </div>

    @if ($errors->any())
        <div class="error-message">
            {{ $errors->first('email') }}
        </div>
    @endif

    <form wire:submit.prevent="login">
        <div class="form-group">
            <label class="form-label" for="email">Tài khoản</label>
            <input type="email" id="email" class="form-input" wire:model.defer="email" placeholder="Nhập tài khoản của bạn" >
        </div>

        <div class="form-group">
            <label class="form-label" for="password">Mật khẩu</label>
            <div class="password-container">
                <input type="password" id="password" class="form-input" wire:model.defer="password" placeholder="Nhập mật khẩu" >
                <button type="button" class="password-toggle" onclick="togglePassword()">👁️</button>
            </div>
        </div>

        <button type="submit" class="login-button">
            Đăng nhập
        </button>
    </form>

    <div class="footer-text">
        <p> Coffee Góc Ảnh</p>
        <p style="margin-top: 5px; font-size: 12px;">Liên hệ hỗ trợ: AlexVu - 0386087403</p>
    </div>
</div>

<script>
function togglePassword() {
    const passwordInput = document.getElementById("password");
    passwordInput.type = passwordInput.type === "password" ? "text" : "password";
}
</script>
