

<?php if($class == 'login' || $class == 'signup'): ?>

<?php else: ?>
		</div>
	</div>
<?php endif; ?>
<input type="hidden" id="base_url" value="<?= base_url('/'); ?>">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js?v=3.3.1"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js?v=3.3.7"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.2/js/adminlte.min.js?v=2.4.2"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/babel-polyfill/6.26.0/polyfill.min.js?v=6.26.0"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/icheck.min.js?v=1.0.2"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.13/vue.min.js?v=2.5.13"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js?v=0.18.0"></script>
<script src="<?= base_url('/'); ?>js/my-script.js?v=<?= get_file_info(FCPATH.'js'.DS.'my-script.js')['date']; ?>"></script>
<?php if( read_file(FCPATH.'js'.DS.$class.'-'.$method.'.js') !== FALSE ): ?>
<script src="<?= base_url('/'); ?>js/<?= $class; ?>-<?= $method; ?>.js?v=<?= get_file_info(FCPATH.'js'.DS.$class.'-'.$method.'.js')['date']; ?>"></script>
<?php endif; ?>
</body>
</html>