module.exports = function( grunt ) {

	'use strict';

	// Project configuration
	grunt.initConfig( {

		pkg: grunt.file.readJSON( 'package.json' ),

		addtextdomain: {
			options: {
				textdomain: 'comment-image-gallery',
			},
			update_all_domains: {
				options: {
					updateDomains: true
				},
				src: [ '*.php', '**/*.php', '!\.git/**/*', '!bin/**/*', '!node_modules/**/*', '!tests/**/*' ]
			}
		},

		babel: {
			options: {
				sourceMap: true
			},
			dist: {
				files: {
					'assets/js/main.js': 'src/js/app.js'
				}
			}
		},

		copy: {
			main: {
				files: [
					{
						expand: true,
						flatten: true,
						src: ['src/js/featherlight/*.js'],
						dest: 'assets/js/'
					},
					{
						expand: true,
						flatten: true,
						src: ['src/js/featherlight/*.css'],
						dest: 'assets/css/'
					}
				]
			}
		},

		uglify: {
			build: {
				src: 'assets/js/main.js',
				dest: 'assets/js/main.min.js'
			}
		},

		watch: {
			scripts: {
				files: ['src/**/*.js'],
				tasks: ['babel'],
				options: {
					spawn: false
				}
			}
		},

		clean: {
			build: {
				src: ['assets']
			}
		},

		wp_readme_to_markdown: {
			your_target: {
				files: {
					'README.md': 'readme.txt'
				}
			},
		},

		makepot: {
			target: {
				options: {
					domainPath: '/languages',
					exclude: [ '\.git/*', 'bin/*', 'node_modules/*', 'tests/*' ],
					mainFile: 'comment-image-gallery.php',
					potFilename: 'comment-image-gallery.pot',
					potHeaders: {
						poedit: true,
						'x-poedit-keywordslist': true
					},
					type: 'wp-plugin',
					updateTimestamp: true
				}
			}
		},
	} );

	grunt.loadNpmTasks( 'grunt-wp-i18n' );
	grunt.loadNpmTasks( 'grunt-wp-readme-to-markdown' );
	grunt.loadNpmTasks( 'grunt-contrib-uglify' );
	grunt.loadNpmTasks( 'grunt-contrib-watch' );
	grunt.loadNpmTasks( 'grunt-contrib-clean' );
	grunt.loadNpmTasks( 'grunt-contrib-copy' );
	grunt.loadNpmTasks( 'grunt-babel' );
	grunt.registerTask( 'default', ['clean', 'babel','copy', 'watch'] );
	grunt.registerTask( 'i18n', ['addtextdomain', 'makepot'] );
	grunt.registerTask( 'readme', ['wp_readme_to_markdown'] );
	grunt.registerTask( 'prod', ['clean', 'babel', 'uglify', 'copy'] );

	grunt.util.linefeed = '\n';

};
