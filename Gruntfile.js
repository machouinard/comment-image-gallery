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
					'dist/js/main.js': 'src/js/app.js'
				}
			}
		},

		uglify: {
			build: {
				src: 'dist/js/main.js',
				dest: 'dist/js/main.min.js'
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
				src: ['dist']
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
	grunt.loadNpmTasks( 'grunt-babel' );
	grunt.registerTask( 'default', ['clean', 'babel','readme', 'watch'] );
	grunt.registerTask( 'i18n', ['addtextdomain', 'makepot'] );
	grunt.registerTask( 'readme', ['wp_readme_to_markdown'] );
	grunt.registerTask( 'prod', ['clean', 'babel', 'uglify'] );

	grunt.util.linefeed = '\n';

};
