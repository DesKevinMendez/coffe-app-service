import { useAuth } from '@/stores/auth';
import { NavigationGuardNext, _RouteLocationBase } from 'vue-router';

export const ifAuthenticated = (
  to: _RouteLocationBase,
  from: _RouteLocationBase,
  next: NavigationGuardNext
) => {
  const auth = useAuth();
  if (auth.isAuth) {
    next();
    return;
  }
  next({ name: 'login' });
};
export const ifNotAuthenticated = (
  to: _RouteLocationBase,
  from: _RouteLocationBase,
  next: NavigationGuardNext
) => {
  const auth = useAuth();
  if (!auth.isAuth) {
    next();
    return;
  }
  next({ name: 'home' });
};
