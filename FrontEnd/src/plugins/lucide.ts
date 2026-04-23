import type { App } from 'vue'
import {
  NotebookText,
  User,
  Settings,
  Phone,
  MapPin,
  SquarePen,
  Save,
  X,
  CircleCheck,
  CircleX,
  Plus,
  Trash2,
  Play,
  FileText,
  Clipboard,
  Check,
  Lock,
  LogIn,
  Gauge,
  Users,
  Bell,
  MessageSquare,
  Calendar,
  LogOut


} from 'lucide-vue-next'

export function registerIcons(app: App) {
  app.component('IconNote', NotebookText)
  app.component('IconUser', User)
  app.component('IconSettings', Settings)
  app.component('IconPhone', Phone)
  app.component('IconMapPin', MapPin)
  app.component('IconEdit', SquarePen)
  app.component('IconSave', Save)
  app.component('IconX', X)
  app.component('IconSuccess', CircleCheck)
  app.component('IconError', CircleX)
  app.component('IconPlus', Plus)
  app.component('IconTrash', Trash2)
  app.component('IconPlay', Play)
  app.component('IconFileText', FileText)
  app.component('IconClipboard', Clipboard)
  app.component('IconCheck', Check)
  app.component('IconLock', Lock)
  app.component('IconLogIn', LogIn)
  app.component('IconGauge', Gauge)
  app.component('IconUsers', Users)
  app.component('IconBell', Bell)
  app.component('IconMessageSquare', MessageSquare)
  app.component('IconCalendar', Calendar)
  app.component('IconLogOut', LogOut)
}


// import type { App, Component } from 'vue'
// import * as icons from 'lucide-vue-next'

// export function registerIcons(app: App) {
//   Object.entries(icons).forEach(([name, component]) => {
//     if (typeof component === 'function') {
//       app.component(`Icon${name}`, component as Component)
//     }
//   })
// }