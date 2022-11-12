import app from 'flarum/admin/app';
import TwitchOAuthPage from './components/TwitchOAuthPage';

app.initializers.add('ianm-oauth-twitch', () => {
  app.extensionData.for('ianm-oauth-twitch').registerPage(TwitchOAuthPage);
});
