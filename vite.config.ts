/**
 * SPDX-FileCopyrightText: 2023 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */
import { createAppConfig } from '@nextcloud/vite-config'
import eslint from 'vite-plugin-eslint'
import stylelint from 'vite-plugin-stylelint'

export default createAppConfig({
	main: 'src/main.js',
	personalSettings: 'src/personalSettings.js',
	adminSettings: 'src/adminSettings.js',
	imageGenerationReference: 'src/imageGenerationReference.js',
	textGenerationReference: 'src/textGenerationReference.js',
	speechToTextReference: 'src/speechToTextReference.js',
	assistantPage: 'src/assistantPage.js',
}, {
	config: {
		css: {
			modules: {
				localsConvention: 'camelCase',
			},
		},
		plugins: [eslint(), stylelint()],
	},
})