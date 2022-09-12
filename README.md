Missing fs/promises import in Node 12 + expo ~46.0.9

change var _promises = __importDefault(require("fs")).default.promises;//_interopRequireDefault(require("fs/promises"));

in:

node_modules\@expo\cli\build\src\start\docto\typescript\TypeScriptProjectPrerequisite.js
node_modules\@expo\cli\build\src\start\server\middleware\InterstitialPageMiddleware.js
node_modules\@expo\cli\build\src\start\server\middleware\resolveAssets.js
node_modules\@expo\cli\build\src\start\server\middleware\webpack\tls.js (for web)

https://stackoverflow.com/questions/71565176/how-to-use-your-expo-react-native-app-offline-without-running-in-terminal
https://www.mongodb.com/developer/products/realm/build-offline-first-react-native-mobile-app-with-expo-and-realm/

https://blog.logrocket.com/build-better-forms-with-react-native-ui-components/

expo