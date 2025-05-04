export interface LoginPayload {
  email: string;
  password: string;
}

export interface LoginError {
  email?: string;
  password?: string;
  general?: string;
}
