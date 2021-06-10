<?php if (isset($component)) { $__componentOriginal3d62dbed0010cc6c2e3e99ed543a0ae1086554a4 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\TemplateLayout::class, []); ?>
<?php $component->withName('template-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
    <div class="content w-full">
        <div class="bg-gray-800 pt-3">
            <div class="rounded-tl-3xl bg-gradient-to-r from-blue-900 to-gray-800 p-4 shadow text-2xl text-white">
                <h3 class="font-bold pl-2"><?php echo e($tittle); ?></h3>
            </div>
        </div>
        <div class="grid grid-cols-12">
            <div class="w-full text-center mt-2 ml-1 col-span-4">
                <form action="<?php echo e(route('data.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="max-w-sm mx-auto p-1 pr-0 flex items-start form-group">
                        <input type="number" name="skor" for="skor" placeholder="Masukkan Skor" class="<?php $__errorArgs = ['skor'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> focus:outline-none focus:ring focus:border-blue-300 flex-1 appearance-none text-xs rounded shadow p-3 text-grey-dark mr-2 focus:outline-none">
                        <div class="ml-4 text-sm text-left text-red-600"><?php $__errorArgs = ['skor'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
                        <div>
                            <button type="submit" class="appearance-none bg-green-800 hover:bg-green-700 text-white focus:outline-none focus:ring focus:border-blue-300 text-xs font-thin tracking-wide uppercase p-3 rounded shadow hover:bg-indigo-light">Input</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="grid-3 px-2 mt-2 ml-1">
            <div>
                <form action="<?php echo e(route('importdata')); ?>" method="POST" enctype="multipart/form-data" class="">
                    <?php echo e(csrf_field()); ?>

                    <div class="form-group">
                        <input type="file" name="file">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full">Import</button>
                    </div>
                    <!-- <?php echo csrf_field(); ?>
                    <label class="w-64 flex flex-col items-center px-4 py-6 bg-white text-blue rounded-lg shadow-lg tracking-wide uppercase border border-blue-400 cursor-pointer hover:bg-blue-400 hover:text-white">
                        <svg class="w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                        </svg>
                        <span class="mt-2 text-base leading-normal">Import File</span>
                        <input type='file' class="hidden" />
                    </label> -->
                </form>
            </div>
            <div class="col-span-2 my-5">
                <a href="/exportdata" class="mt-5 rounded bg-green-600 p-2 text-white hover:bg-green-500 text-xs font-thin">Export</a>
            </div>
            <!-- <a href="/exportdata" class="rounded bg-blue-800 p-2 text-white hover:bg-blue-700 text-xs font-thin">Import</a> -->
        </div>
        <div class="table w-full p-2">
            <table class="w-2/5 border">
                <thead>
                    <tr class="bg-gray-50 border-b">
                        <th class="p-0 border-r cursor-pointer text-sm font-thin text-gray-500">
                            <div class="flex items-center justify-center">
                                No
                            </div>
                        </th>
                        <th class="p-2 border-r cursor-pointer text-sm font-thin text-gray-500">
                            <div class="flex items-center justify-center">
                                Skor
                            </div>
                        </th>
                        <th class="p-2 border-r cursor-pointer text-sm font-thin text-gray-500">
                            <div class="flex items-center justify-center">
                                Action
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody class="py-5">
                    <?php $no = 1; ?>
                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="bg-gray-100 text-center border-b text-base text-gray-600">
                        <td class="p-2 border-r"><?php echo e($no); ?></td>
                        <td class="p-2 border-r"><?php echo e($item -> skor); ?></td>
                        <td>
                            <form action="<?php echo e(route('data.destroy',$item->id)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <a href="<?php echo e(route('data.edit',$item->id)); ?>" class="rounded bg-blue-500 p-2 text-white hover:bg-blue-400 text-xs font-thin">Edit</a>
                                <button type="submit" class="rounded bg-red-500 p-2 text-white hover:bg-red-400 text-xs font-thin">Remove</button>
                            </form>
                        </td>
                    </tr>
                    <?php $no++ ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
 <?php if (isset($__componentOriginal3d62dbed0010cc6c2e3e99ed543a0ae1086554a4)): ?>
<?php $component = $__componentOriginal3d62dbed0010cc6c2e3e99ed543a0ae1086554a4; ?>
<?php unset($__componentOriginal3d62dbed0010cc6c2e3e99ed543a0ae1086554a4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\lrvl-statistik\resources\views/data.blade.php ENDPATH**/ ?>