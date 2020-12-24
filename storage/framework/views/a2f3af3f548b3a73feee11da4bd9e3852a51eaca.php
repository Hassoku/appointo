<?php $__env->startSection('content'); ?>
    <span class="logo-box">
        <img src="<?php echo e($frontThemeSettings->logo_url); ?>" alt="logo">
    </span>
    <h4 class="mb-30"><?php echo app('translator')->getFromJson('app.signInToAccount'); ?></h4>
    <form action="<?php echo e(route('login')); ?>" method="post">
        <?php echo csrf_field(); ?>
        <div class="input-group">
            <i class="fa fa-envelope"></i>
            <input type="email" name="email" id="email" class="form-control <?php echo e($errors->has('email') ? ' is-invalid' : ''); ?>" value="<?php echo e(old('email')); ?>" required autofocus>
            <label for="email"><?php echo app('translator')->getFromJson('app.email'); ?></label>
            <?php if($errors->has('email')): ?>
                <span class="invalid-feedback" role="alert">
                    <strong><?php echo e($errors->first('email')); ?></strong>
                </span>
            <?php endif; ?>
        </div>
        <div class="input-group">
            <i class="fa fa-lock"></i>
            <input type="password" id="password" class="form-control <?php echo e($errors->has('password') ? ' is-invalid' : ''); ?>" name="password" required>
            <label for="password"><?php echo app('translator')->getFromJson('app.password'); ?></label>
            <?php if($errors->has('password')): ?>
                <span class="invalid-feedback" role="alert">
                    <strong><?php echo e($errors->first('password')); ?></strong>
                </span>
            <?php endif; ?>
        </div>
        <div class="centering v-center">
                <span class="mb-4">
                    <input type="checkbox" name="remember" id="remember" <?php echo e(old('remember') ? 'checked' : ''); ?>>
                    <label for="remember"><?php echo app('translator')->getFromJson('app.rememberMe'); ?></label>
                </span>
                <span class="mb-4">
                    <a href="<?php echo e(route('password.request')); ?>" class="c-theme"> <?php echo app('translator')->getFromJson('app.forgotPassword'); ?></a>
                </span>
        </div>
        <div class="d-flex justify-content-between flex-wrap">
            <a href="<?php echo e(route('front.index')); ?>" class="btn btn-custom"><?php echo app('translator')->getFromJson('front.navigation.backToHome'); ?></a>
            <button type="submit" class="btn btn-custom btn-blue"><?php echo app('translator')->getFromJson('app.signIn'); ?></button>
        </div>
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\laragon\www\booking\resources\views/auth/login.blade.php ENDPATH**/ ?>