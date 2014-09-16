module.exports = function(grunt) {

  	// Project configuration.
	grunt.initConfig({
	pkg: grunt.file.readJSON('package.json'),
	
		watch: {
			compass: {
				files: 'wordpress/wp-content/themes/pera_soho/scss/**/*.scss',
				tasks: ['compass:dev'],
				options: {
					interrupt: true
				}
			}
		},
		compass: {
			dev: {
				options: {
					sassDir: 'wordpress/wp-content/themes/pera_soho/scss/',
					cssDir: 'wordpress/wp-content/themes/pera_soho/',
					outputStyle: 'expanded'
				}
			}
		}
	});

	grunt.loadNpmTasks("grunt-contrib-compass");
	grunt.loadNpmTasks("grunt-contrib-watch");

	// Build task
	grunt.registerTask("build", ["compass:dev"]);

};