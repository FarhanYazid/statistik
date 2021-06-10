<?php if (isset($component)) { $__componentOriginal3d62dbed0010cc6c2e3e99ed543a0ae1086554a4 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\TemplateLayout::class, []); ?>
<?php $component->withName('template-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
    <div class="bg-gray-800 pt-3">
        <div class="rounded-tl-3xl bg-gradient-to-r from-blue-900 to-gray-800 p-4 shadow text-2xl text-white">
            <h3 class="font-bold pl-2"><?php echo e($tittle); ?></h3>
        </div>
    </div>
    <div class="grid grid-cols-12">
        <div class="w-full text-center mt-2 ml-1 col-span-4">
            <form action="<?php echo e((isset($data))?route('data.update', $data->id):route('data.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php if(isset($data)): ?>
                <?php echo method_field('PUT'); ?>
                <?php endif; ?>
                <div class="max-w-sm mx-auto p-1 pr-0 flex items-start form-group">
                    <input type="number" name="skor" for="skor" placeholder="Masukkan Skor" value="<?php echo e((isset($data))?$data->skor:old('data')); ?>" class="<?php $__errorArgs = ['skor'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> focus:outline-none focus:ring focus:border-blue-300 flex-1 appearance-none  rounded shadow p-3 text-grey-dark mr-2 focus:outline-none">
                    <div class="ml-4 text-sm text-left text-red-600"><?php $__errorArgs = ['skor'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
                    <div>
                        <button type="submit" class="appearance-none bg-green-800 hover:bg-green-700 text-white focus:outline-none focus:ring focus:border-blue-300  font-thin tracking-wide uppercase p-3 rounded shadow hover:bg-indigo-light">Input</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
 <?php if (isset($__componentOriginal3d62dbed0010cc6c2e3e99ed543a0ae1086554a4)): ?>
<?php $component = $__componentOriginal3d62dbed0010cc6c2e3e99ed543a0ae1086554a4; ?>
<?php unset($__componentOriginal3d62dbed0010cc6c2e3e99ed543a0ae1086554a4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\lrvl-statistik\resources\views/edit.blade.php ENDPATH**/ ?>