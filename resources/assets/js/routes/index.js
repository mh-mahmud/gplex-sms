import VueRouter from 'vue-router';
import userRoutes from './user';
import contactRoutes from './contact';
import templateRoutes from './template';
import scheduleRoutes from './schedule';
import historyRoutes from './history';
import composeRoutes from './compose';
import textRoutes from './text';
import outboundRoutes from './outbound';
import dashboardRoutes from './dashboard';
import chatsRoutes from './chats';
import groupRoutes from './group';
import inboxRoutes from './inbox';
import auditLogRoutes from './auditLog';
const baseRoutes = [];
const routes = baseRoutes.concat(userRoutes, dashboardRoutes, chatsRoutes, contactRoutes, groupRoutes, templateRoutes, scheduleRoutes, historyRoutes, composeRoutes, textRoutes, outboundRoutes, inboxRoutes, auditLogRoutes);

export default new VueRouter({
    routes,
});