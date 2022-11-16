import app from 'flarum/admin/app';
import { ConfigureWithOAuthPage } from '@fof-oauth';

app.initializers.add('ianm-oauth-twitch', () => {
  app.extensionData.for('ianm-oauth-twitch').registerPage(ConfigureWithOAuthPage);
});
